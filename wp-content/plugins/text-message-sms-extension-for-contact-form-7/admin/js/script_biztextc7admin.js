function ready(fn) {
  if (document.readyState != 'loading') {
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

ready(function () {

  var inputNumberField = document.getElementById("wpbiztextc7_setting_email_notif_number");

  // validation
  inputNumberField.setAttribute("maxlength", 10);

  inputNumberField.addEventListener("input", function (event) {

    var number = event.target.value;
    var formatNumber = number.replace(/[^\d]+/g, '')
      .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');

    event.target.value = formatNumber;



  });

});

function isBizTextIdValid() {

  var route = document.querySelector('#wpbiztextc7-global-settings-submit').getAttribute('data-link');
  var id = document.querySelector('#wpbiztextc7_setting_biztext_id').value;
  var spinner = document.querySelector('#wpbiztextc7-spinner');
  spinner.classList.add('is-active');

  var parm = 'action=wpbiztextc7_verify_id&id=' + encodeURIComponent(id);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", route, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
  xhr.send(parm);

  var verification_text = document.querySelector('#wpbiztextc7-verification-text');
  
  var previous_generated_notice = document.querySelector('.wpbiztextc7_custom_notice');
  if (previous_generated_notice !== null) {
    previous_generated_notice.style.transition = "opacity 2s ease";

    previous_generated_notice.style.opacity = 0;
    setTimeout(function () {
      previous_generated_notice.parentNode.removeChild(previous_generated_notice);
    }, 1000);
  }

  var global_settings_form = document.querySelector('#wpbiztextc7_global_settings_form');

  xhr.onreadystatechange = function () {

    var parent_div = document.querySelector('.wrap.wpbiztextc7-main-settings');
    
    var result_notice;
    console.log(this.responseText);
    if (this.readyState == 4 && this.responseText == 1) {
      document.getElementById('wpbiztextc7_setting_verification_status').value = 'Y';
      result_notice = makeAdminNotice('Verification success. Remember to save your Biz Text Id.', 'notice-success');
      parent_div.insertBefore(result_notice, global_settings_form);
      verification_text.innerText = 'Biz Text Id verified.';
      verification_text.classList.add('wpbiztextc7-success');
      verification_text.classList.remove('wpbiztextc7-error');
      spinner.classList.remove('is-active');
      global_settings_form.submit();

    }
    if (this.readyState == 4 && this.responseText == 0) {
      document.getElementById('wpbiztextc7_setting_verification_status').value = 'N';
      result_notice = makeAdminNotice('Verification failed. Please enter a valid Biz Text Id.', 'notice-error');
      parent_div.insertBefore(result_notice, global_settings_form);
      verification_text.innerText = 'Biz Text Id not verified.';
      verification_text.classList.remove('wpbiztextc7-success');
      verification_text.classList.add('wpbiztextc7-error');
      spinner.classList.remove('is-active');
      global_settings_form.submit();

    }

    
  }



  function makeAdminNotice(description, type) {
    var div = document.createElement('div');
    div.classList.add('notice', type, 'is-dismissible', 'wpbiztextc7_custom_notice');

    /* create paragraph element to hold message */

    var p = document.createElement('p');

    /* Add message text */

    p.appendChild(document.createTextNode(description));

    // Optionally add a link here

    /* Add the whole message to notice div */

    div.appendChild(p);

    /* Create Dismiss icon */

    var b = document.createElement('button');
    b.setAttribute('type', 'button');
    b.classList.add('notice-dismiss');

    /* Add screen reader text to Dismiss icon */

    var bSpan = document.createElement('span');
    bSpan.classList.add('screen-reader-text');
    bSpan.appendChild(document.createTextNode('Dismiss this notice'));
    b.appendChild(bSpan);

    /* Add Dismiss icon to notice */

    div.appendChild(b);

    b.addEventListener('click', function () {
      div.parentNode.removeChild(div);
    });

    return div;

  }
}
