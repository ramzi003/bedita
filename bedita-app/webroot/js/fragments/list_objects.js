function count_check_selected() {
    var checked = 0;
    $('input[type=checkbox].objectCheck').each(function(){
        if($(this).prop("checked")) {
            checked++;
        }
    });
    return checked;
}

$(document).ready(function(){

    // avoid to perform double click
    $("a:first", ".indexlist .obj").click(function(e){ 
        e.preventDefault();
    });

    $(".indexlist .obj TD").not(".checklist").css("cursor","pointer").click(function(i) {
        document.location = $(this).parent().find("a:first").attr("href"); 
    } );

    $("#deleteSelected").bind("click", function() {
        if(count_check_selected()<1) {
            alert(no_items_checked_msg);
            return false;
        }
        if(!confirm(messageSelected)) 
            return false ;  
        $("#formObject").prop("action", urls['deleteSelected']) ;
        $("#formObject").submit() ;
    });

    $("#assocObjects").click( function() {
        if(count_check_selected()==0) {
            alert(no_items_checked_msg);
            return false;
        }
        if($('#areaSectionAssoc').val() == "") {
            alert(sel_copy_to_msg);
            return false;
        }
        var op = ($('#areaSectionAssocOp').val()) ? $('#areaSectionAssocOp').val() : "copy";
        $("#formObject").prop("action", urls[op + 'ItemsSelectedToAreaSection']) ;
        $("#formObject").submit() ;
    });

    $(".opButton").click( function() {
        if(count_check_selected()==0) {
            alert(no_items_checked_msg);
            return false;
        }
        if(this.id.indexOf('changestatus') > -1) {
            if($('#newStatus').val() == "") {
                alert(sel_status_msg);
                return false;
            }
        }
        if(this.id == 'assocObjectsCategory') {
            if($('#objCategoryAssoc').val() == "") {
                alert(sel_category_msg);
                return false;
            }
        }
        if(this.id == 'disassocObjectsCategory') {
            $('#objCategoryAssoc').val($('#filter_category').val());
        }
        $("#formObject").prop("action",urls[this.id]) ;
        $("#formObject").submit() ;
    });
});