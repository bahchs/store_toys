// JavaScript Document
const name = document.getElementById("name");
const gmail = document.getElementById("gmail");
const urlParams = new URLSearchParams(window.location.search);
const brandName = urlParams.get('brand_name');
const userName = user.fullname;
const userGmail = user.email;
const logoutBtn = document.querySelector(".logout-btn");
const searchForm = document.querySelector(".search-form");
searchForm.addEventListener("submit", performSearch);
name.textContent = `Xin chào ${userName}`;
gmail.textContent = `Gmail của bạn: ${userGmail}`;
getBrand();
function getBrand(){
    fetch(brandUrl)
    .then(res => res.json())
    .then(datas => {
        var htmls = datas.map(renderBrand);
        var html = htmls.join('');
        brandItem.innerHTML = html;
    })
    .catch(error => console.log(error));
}
function performSearch(event) {
    event.preventDefault();
    const searchInput = document.querySelector(".search-input");
    const searchTerm = searchInput.value;
    window.location.href = `Search.html?search=${encodeURIComponent(searchTerm)}`;
}
function renderBrand(data) {
    const encodedBrandName = encodeURIComponent(data.brand_name);
    return `<li class="list-content hover-region">
              <a href="Brand.html?brand_name=${encodedBrandName}" class="content">${data.brand_name}</a>
            </li>`;
}

logoutBtn.addEventListener("click", function(){
	localStorage.removeItem('user');
    window.location.href = '../login/Login.html';
})