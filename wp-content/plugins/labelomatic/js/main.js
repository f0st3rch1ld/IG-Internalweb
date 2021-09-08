// This script controls the fields you can see while selecting a form to fill out.
document
  .getElementById("add-label-select")
  .addEventListener("change", function () {
    let formVal = document.getElementById("add-label-select").value;
    let idVal = formVal + "-form";

    if (formVal != "") {
      document
        .getElementById("add-label-select")
        .setAttribute("form", "labels-order");
    } else {
      document.getElementById("add-label-select").setAttribute("form", "");
    }

    let orderForms = document.getElementsByClassName("order-form");
    for (i = 0; orderForms.length > i; i++) {
      orderForms[i].style.display = "none";
    }

    let dynamicFormVal = document.getElementsByClassName("dynamic-form");
    for (i = 0; dynamicFormVal.length > i; i++) {
      dynamicFormVal[i].setAttribute("form", "");
    }

    document.getElementById(idVal).style.display = "flex";

    let dynamicFormValReset = document.getElementsByClassName(formVal);
    for (i = 0; dynamicFormValReset.length > i; i++) {
      dynamicFormValReset[i].setAttribute("form", "labels-order");
    }
  });

let updateLabels = () => {
  let formElements = document.getElementsByClassName("dynamic-form");
  for (i = 0; formElements.length > i; i++) {
    formElements[i].value = formElements[i].value.replace(/'/g, "&rsquo;");
    formElements[i].value = formElements[i].value.replace(/"/g, "&rdquo;");
    formElements[i].value = formElements[i].value.replace(/\\/g, "&bsol;");
  }

  let firstName = document.getElementById("requester-first-name").value;
  let lastName = document.getElementById("requester-last-name").value;
  let dept = document.getElementById("requester-dept").value;

  document.getElementById(
    "project-name"
  ).value = `${lastName}-${firstName}-${dept}`;
  document.getElementById("emp-name").value = `${firstName} ${lastName}`;
  document.getElementById("dept").value = `${dept}`;
};

let convertToEdit = (x) => {
  let dataToConvert = document.getElementsByClassName("edit-label-" + x);
  for (i = 0; dataToConvert.length > i; i++) {
    dataToConvert[i].value = dataToConvert[i].value.replace(/'/g, "&rsquo;");
    dataToConvert[i].value = dataToConvert[i].value.replace(/"/g, "&rdquo;");
    dataToConvert[i].value = dataToConvert[i].value.replace(/\\/g, "&bsol;");
  }
};

let editLabels = (x) => {
  let allSaveButtons = document.getElementsByClassName("save-edits-submit");
  for (i = 0; allSaveButtons.length > i; i++) {
    allSaveButtons[i].setAttribute("style", "display:none;");
  }
  document
    .getElementById("save-edits-" + x)
    .setAttribute("style", "display:flex;");
};

let prepareToSave = (x) => {
  document
    .getElementById("label-index-" + x)
    .setAttribute("form", "edit-label");

  let labelDataToSave = document.getElementsByClassName("edit-label-" + x);
  for (i = 0; labelDataToSave.length > i; i++) {
    labelDataToSave[i].setAttribute("form", "edit-label");
  }
};

let cancelSave = (x) => {
  document.getElementById("label-index-" + x).removeAttribute("form");

  let labelDataToSave = document.getElementsByClassName("edit-label-" + x);
  for (i = 0; labelDataToSave.length > i; i++) {
    labelDataToSave[i].removeAttribute("form");
  }
};

document
  .getElementById("email-order-submit")
  .addEventListener("click", function () {
    let firstName = document.getElementById("requester-first-name").value;
    let lastName = document.getElementById("requester-last-name").value;
    let dept = document.getElementById("requester-dept").value;

    document.getElementById("emp-name").value = `${firstName} ${lastName}`;
    document.getElementById("dept").value = `${dept}`;
  });

document
  .getElementById("add-to-label-order")
  .addEventListener("click", updateLabels);
document
  .getElementById("save-label-order")
  .addEventListener("click", updateLabels);

// This script allows you to copy a shareable link to your clipboard.
function copyLink() {
  // Get the Text Field
  var copyText = document.getElementById("copy-link");

  // Select the Text Field
  copyText.select();
  copyText.setSelectionRange(0, 99999);

  // Copy the text inside the text field
  document.execCommand("copy");

  // Alert the copied text
  alert("Share Link Copied!");
}

// This function switches content tabs
function switchTab(evt, tabName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "flex";
  evt.currentTarget.className += " active";
}

// Copy Function
let copyShareUrl = () => {
  let copyLink = document.getElementById("share-order-url");
  copyLink.select();
  copyLink.setSelectionRange(0, 99999);
  document.execCommand("copy");
  alert("Shareable Link Copied!");
};

// Accordion JS
let acc = document.getElementsByClassName("accordion-button");
for (i = 0; acc.length > i; i++) {
  acc[i].addEventListener("click", function () {
    this.classList.toggle("active");

    let panel = this.nextElementSibling;
    if (panel.hasAttribute("style")) {
      panel.removeAttribute("style");
    } else {
      panel.setAttribute(
        "style",
        "display:flex !important; padding:15px 15px 50px 15px !important; margin-bottom:50px !important;"
      );
    }
  });
}
