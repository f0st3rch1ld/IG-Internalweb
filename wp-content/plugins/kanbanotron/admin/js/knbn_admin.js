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
    knbnAdminTabs[i].setAttribute('class', 'knbn-admin-tab');
  }
};

let knbnAdminTabs = document.getElementsByClassName("knbn-admin-tab");
for (i = 0; knbnAdminTabs.length > i; i++) {
  knbnAdminTabs[i].addEventListener("click", function () {
    hideTabs();
    resetActive();
    this.setAttribute('class', 'knbn-admin-tab active');
    document
      .getElementById(this.id + "-container")
      .setAttribute("style", "display:flex;");
  });
}
