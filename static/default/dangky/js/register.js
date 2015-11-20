function dang_ky() {

  var txtType_id = $.trim($('#type_id').val());
  var txtName = $.trim($('#full_name').val());
  var txtLastName = $.trim($('#last_name').val());
  var txtAddress = $('#address').val();
  var txtPhone = $('#phone').val();
  var txtEmail = $('#email').val().toLowerCase();
  var txtMssv = $.trim($('#mssv').val());
  var txtCourse_id = $.trim($('#course_id').val());
  var txtiI_schedule = $.trim($('#id_schedule').val());

  

  if (txtName.length < 1) {
    alert('Vui lòng nhập Tên!');
    return false;
  }

  if (txtLastName.length < 1) {
    alert('Vui lòng nhập Họ và tên đệm!');
    return false;
  }

  if (txtEmail.length < 1) {
    alert('Vui lòng nhập Email!');
    return false;
  }

  var regular = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
  if (!regular.test(txtEmail)) {
    alert('Email không hợp lệ, vui lòng thử lại!');
    return false;
  }

  if (txtPhone.length < 1) {
    alert('Vui lòng nhập Số điện thoại');
    return false;
  }

  if (isNaN(txtPhone))
  {
    alert('Vui lòng nhập số cho Điện thoại');
    return false;
  }

  if (txtType_id == -1) {
    alert('Vui lòng chọn Trường!');
    return false;
  }

  if (txtMssv.length < 1) {
    alert('Vui lòng nhập MSSV');
    return false;
  }

  if (txtAddress == -1) {
    alert('Vui lòng chọn địa điểm học!');
    return false;
  }

  if (txtCourse_id == -1 || txtCourse_id == 0 || txtCourse_id == 6) {
    alert('Vui lòng chọn Lớp!');
    return false;
  }
  if (txtiI_schedule == -1) {
    alert('Vui lòng chọn Lịch học!');
    return false;
  }

  $('#btn-accept').attr('style', 'pointer-events:none');

  var postData = $('#frm-dang-ky').serializeArray();

  $.post('register.php',
   postData,
   function(data){
      alert( data);
  });

  $('#btn-accept').removeProp('style');
  return false;
}

function numbersonly(myfield, e, dec) {
  var key;
  var keychar;

  if (window.event)
    key = window.event.keyCode;
  else if (e)
    key = e.which;
  else
    return true;
  keychar = String.fromCharCode(key);

  // control keys
  if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
    return true;

  // numbers
  else if ((("0123456789").indexOf(keychar) > -1))
    return true;

  // decimal point jump
  else if (dec && (keychar == ".")) {
    myfield.form.elements[dec].focus();
    return false;
  } else
    return false;
}