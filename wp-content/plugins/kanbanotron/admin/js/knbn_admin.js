let hideTabs = () => {
  let knbnAdminContainers = document.getElementsByClassName(
    "knbn-admin-container"
  );
  for (x = 0; knbnAdminContainers.length > x; x++) {
    knbnAdminContainers[x].setAttribute("style", "display:none;");
  }
};

let resetActive = () => {
  let knbnAdminTabs = document.getElementsByClassName("knbn-admin-tab");
  for (i = 0; knbnAdminTabs.length > i; i++) {
    knbnAdminTabs[i].setAttribute("class", "knbn-admin-tab");
  }
};

let knbnAdminTabs = document.getElementsByClassName("knbn-admin-tab");
for (i = 0; knbnAdminTabs.length > i; i++) {
  knbnAdminTabs[i].addEventListener("click", function () {
    hideTabs();
    resetActive();
    this.setAttribute("class", "knbn-admin-tab active");
    document
      .getElementById(`${this.id}-container`)
      .setAttribute("style", "display:flex;");
  });
}

let upManKnbnFields = (x) => {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.getElementById("mku-form-fields").innerHTML = this.responseText;
  };
  xhttp.open(
    "GET",
    `../../wp-content/plugins/kanbanotron/admin/components/load_mku_form_fields.php/?xhttp=1&wpknbnpid=${x}`
  );
  xhttp.send();
};

document
  .getElementById("kanban-selection")
  .addEventListener("change", function () {
    if (this.value != "add-new-knbn") {
      upManKnbnFields(this.value);
    }
  });

let generateCode = (x, y) => {
  let qrcode = new QRCode(document.getElementById(`${x}-qrcode`), {
    width: 100,
    height: 100,
  });
  console.log(qrcode);
  qrcode.makeCode(y.value);
  console.log(y);
}

window.onload(function() {
  let allDaCodez = document.getElementsByClassName('qrcode-container');
  for (i = 0; allDaCodez.length > i; i++) {
    let uid = this.getAttribute('data');
    let newCode = `http://internalweb/kanbanotron/?knbn_uid=${uid}`;
    generateCode(uid, newCode);
  }
});