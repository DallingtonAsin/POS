
$(document).ready(function(){
  $('.group').hide();
  var user = $('.user').text();
 
  $('#dialog').dialog({
   autoOpen:false,
   modal:true,
 });


//Open change password dialog when settings click is liked
$('.settings').click(function(){
  $('#dialog').dialog("open");
  var close_btn = $(".ui-dialog-titlebar-close");
  close_btn.html("<span class='fa fa-times'></span>");

});


//function that checks if both password fields are filled in
$('#ChangePassword').click(function(){
 var password1,password2;
 password1 = $('#password1').val();
 password2 = $('#password2').val();
 if(!password1 || !password2){
   alert("Please fill in both passwords");
 }
 if(password1 && password2){
  switch(true){
    case (password1!=password2):
    alert("Your passwords don't match");
    break;
    case (password1==password2):
    ChangePassword(password1,password2);
    break;
  }
}
});



//method ChangePassword that triggers a php method that changes password
function ChangePassword(pass1,pass2){
  var userDetails = [];
  var group = $('.group').text();
  userDetails.push(pass1);
  userDetails.push(pass2);
  userDetails.push(user);
  userDetails.push(group);
  $.ajax({
   url:'../php/hostsys.inc.php',
   method:'POST',
   data:{
    changepassword:1,
    dataArray:userDetails,
  },
  success:function(data){
    BootstrapDialog.show({
      size:BootstrapDialog.SIZE_SMALL,
      title:"<b class='err-title'>Message</b>",
      message: data,
      buttons:[{
        id:'btn-ok',
        label:'ok',
        cssClass:'btn-success',
        autospin:false,
        action:function(id){
          id.close();
        }
      }]
    });
    $("#dialog").dialog("close");
    console.log(data);
  },
  error:function(data){
    alert(data);

  },
});
} // end of method ChangePassword()


});
