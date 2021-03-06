<?php
/*-----8<--------------------------------------------------------------------
 *
* BEdita - a semantic content management framework
*
* Copyright 2013 ChannelWeb Srl, Chialab Srl
*
*------------------------------------------------------------------->8-----
*/

App::import('Component', 'BeAuth');
App::import('Vendor', 'twitteroauth', array('file' => 'twitteroauth' . DS . 'twitteroauth.php'));

/**
 * Twitter User auth component
*/
class BeAuthTwitterComponent extends BeAuthComponent{
    var $components = array('Transaction');
    var $uses = array('Image', 'Card');
    public $userAuth = 'twitter';
    protected $params = null;
    protected $vendorController = null;
    protected $userIdPrefix = 'twitter-';
    public $relatedBy = 'nickname';
    public $disabled = false;

    public function startup($controller=null) {
        $this->controller = $controller;
        $this->Session = $controller->Session;

        $this->params = Configure::read("extAuthParams");

        if (isset( $this->params[$this->userAuth] ) && isset( $this->params[$this->userAuth]['keys'] )) {
            $this->vendorController = new TwitterOAuth(
                    $this->params[$this->userAuth]['keys']['appId'],
                    $this->params[$this->userAuth]['keys']['secret']
                );
            return true;
        } else {
            return false;
        }
    }

    protected function checkSessionKey() {
        if (isset( $this->vendorController )) {
            if(!empty($_REQUEST['oauth_verifier']) && $this->Session->check('twitterOauthTokens')) {
                $oauthTokens = $this->Session->read('twitterOauthTokens');
                if (isset($oauthTokens['oauth_token'])) {
                    $this->vendorController = new TwitterOAuth(
                            $this->params[$this->userAuth]['keys']['appId'],
                            $this->params[$this->userAuth]['keys']['secret'],
                            $oauthTokens['oauth_token'],
                            $oauthTokens['oauth_token_secret']
                        );

                    $accessTokens = $this->vendorController->getAccessToken($_REQUEST['oauth_verifier']);
                    $this->Session->write('twitterAccessTokens', $accessTokens);
                } else {
                    $this->Session->delete('twitterOauthTokens');
                    return false;
                }
            }

            $profile = $this->loadProfile();
            if ($profile != null) {
                /*if (isset($this->params[$this->userAuth]['createUser']) && $this->params[$this->userAuth]['createUser']) {
                    $this->createUser($profile);
                }*/
                return $this->login();
            }
            return false;
        } else {
            return false;
        }
    }

    public function login() {
        $policy = $this->Session->read($this->sessionKey . 'Policy');
        $authGroupName = $this->Session->read($this->sessionKey . 'AuthGroupName');
        $userid = null;

        if (!isset( $this->vendorController )) {
            return;
        }

        if ($this->Session->check('twitterProfile')) {
            $profile = $this->loadProfile();
            if ($profile != null) {
                $userid = $profile->screen_name;
            }
        }

        //get the user
        if ($userid) {
            //BE user
            $user = ClassRegistry::init('User');
            $user->containLevel("default");
            $u = $user->find('first', array(
                    'conditions' => array(
                        'auth_params' => $userid,
                        'auth_type' => $this->userAuth
                    )
                )
            );

            if (empty($u['User'])) {
                $this->Session->write('externalLoginRequestFailed', $userid);
                return false;
            }

            $userid = $u['User']['userid'];

            if(!$this->loginPolicy($userid, $u, $policy, $authGroupName)) {
                return false;
            }
            return true;

        } else { 
            //get tokens
            $this->loginUrl();
        }
    }

    public function logout() {
        $this->Session->delete('twitterAccessTokens');
        $this->Session->delete('twitterOauthTokens');
        $this->Session->delete('twitterProfile');
    }

    protected function getCurrentUrl() {
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)
            || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = parse_url($currentUrl);

        // use port if non default
        $port = isset($parts['port']) && (($protocol === 'http://' && $parts['port'] !== 80) || ($protocol === 'https://' && $parts['port'] !== 443)) ? ':' . $parts['port'] : '';

        // rebuild
        return $protocol . $parts['host'] . $port . $parts['path'];
    }

    protected function loginUrl() {
        $requestToken = $this->vendorController->getRequestToken($this->getCurrentUrl());
        $this->Session->write('twitterOauthTokens', $requestToken);
        $url = $this->vendorController->getAuthorizeURL($requestToken);
        $this->controller->redirect($url);
    }

    public function getUser() {
        return $this->user;
    }

    public function loadProfile() {
        if ($this->Session->check('twitterProfile')) {
            return $this->Session->read('twitterProfile');
        }
        if ($this->Session->check('twitterAccessTokens')) {
            $accessTokens = $this->Session->read('twitterAccessTokens');
            if (!empty($accessTokens['oauth_token'])) {
                $this->vendorController = new TwitterOAuth(
                        $this->params[$this->userAuth]['keys']['appId'],
                        $this->params[$this->userAuth]['keys']['secret'],
                        $accessTokens['oauth_token'],
                        $accessTokens['oauth_token_secret']
                    );
                $profile = $this->vendorController->get('account/verify_credentials');
                if (property_exists($profile, 'id')) {
                    $this->Session->write('twitterProfile', $profile);
                    return $profile;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function createUser($profile = null, $groups = array(), $createCard = false) {
        if ($profile == null) {
            $profile = $this->loadProfile();
        }

        $user = ClassRegistry::init('User');
        $user->containLevel("minimum");

        $u = $user->find('first', array(
                'conditions' => array(
                    'auth_params' => $profile->screen_name,
                    'auth_type' => $this->userAuth
                )
            )
        );

        if(!empty($u["User"])) {
            return $u;
        }

        //create the data array
        $res = array();
        $res['User'] = array(
            'userid' => $profile->id,
            'realname' => $profile->name,
            'auth_type' => $this->userAuth,
            'auth_params' => $profile->id
        );

        $res['Groups'] = $groups;

        //create the BE user
        $this->userGroupModel($res, $groups);
        
        $user->create();
        if(!$user->save($res)) {
            throw new BeditaException(__("Error saving user", true), $user->validationErrors);
        }
 
        $u = $user->findByUserid($res['User']['userid']);
        if(!empty($u["User"])) {
            if ($createCard) {
                $this->createCard($u, $profile);
            }
            return $u;
        } else {
            return null;
        }
    }

    public function createCard($u, $profile = null) {
        $res = array();
        
        if ($profile == null) {
            $profile = $this->loadProfile();
            if ($profile == null) {
                return false;
            }
        }        

        $res = array(
            'title' => $profile->name,
            'avatar' => $profile->profile_image_url
        );

        $card = ClassRegistry::init("ObjectUser")->find("first", array(
            "conditions" => array("user_id" => $u['User']['id'], "switch" => "card" )
        ));

        $data = array(
            "title" => "",
            "name" => "",
            "surname" => "",
            "birthdate" => "",
            "person_title" => "",
            "gender" => "",
            "status" => "on",
            "ObjectUser" =>  array(
                    "card" => array(
                        0 => array(
                            "user_id" => $u['User']['id']
                        )
                    )
                )
        );

        $data = array_merge($data, $res);

        $avatarId = null;
        if (!empty($data['avatar'])) {
            $avatar = $this->uploadAvatarByUrl($data);
            $avatarId = $avatar->id;
            if ($avatarId) {
                $data['RelatedObject'] = array(
                    'attach' => array()
                );

                $data['RelatedObject']['attach'][$avatarId] = array(
                    'id' => $avatarId
                );
            }
        }

        $this->data = $data;

        $this->Transaction->begin();

        $cardModel = ClassRegistry::init("Card");
        if (!$cardModel->save($this->data)) {
            throw new BeditaRuntimeException(__("Error saving user data", true), $cardModel->validationErrors);
        }

        $this->Transaction->commit();
 
        return $cardModel;
    }

    protected function uploadAvatarByUrl($userData) {
        $this->data = array(
            'title' => $userData['title'] . '\'s avatar',
            'uri' => $userData['avatar'],
            'status' => 'on'
        );
        $this->Transaction->begin();

        $mediaModel = ClassRegistry::init("Image");
        if (!$mediaModel->save($this->data)) {
            throw new BeditaRuntimeException(__("Error saving avatar data", true), $mediaModel->validationErrors);
        }
        $this->Transaction->commit();
        return $mediaModel;
    }
}
?>