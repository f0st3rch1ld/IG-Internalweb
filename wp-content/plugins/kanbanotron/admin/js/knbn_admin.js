let hideTabs = () => {
  let knbnAdminContainers = document.getElementsByClassName(
    "knbn-admin-container"
  );
  for (x = 0; knbnAdminContainers.length > x; x++) {
    knbnAdminContainers[x].removeAttribute("style");
  }
};

let knbnAdminTabs = document.getElementsByClassName("knbn-admin-tab");
for (i = 0; knbnAdminTabs.length > i; i++) {
  knbnAdminTabs[i].addEventListener("click", function () {
    hideTabs();
    document.getElementById(knbnAdminTabs[i].id + "-container").setAttribute('style', 'display:flex;');
  });
}
