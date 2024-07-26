// JavaScript Document
const url = 'http://localhost/StoreToys-BE/API/product';
const name = document.getElementById('product');
const modal = document.querySelector('.js-modal');
const inputCategory = document.getElementById('category');
const inputBrand = document.getElementById('brand');
const inputName = document.getElementById('product_name');
const inputImg = document.getElementById('product_img');
const inputSex = document.getElementById('product_sex');
const inputPrice = document.getElementById('product_price');
const btnConfirmUpdate = document.getElementById('update');
let index = 0;
var ID = 0;
document.addEventListener('DOMContentLoaded', start);

function start() {    
    getProduct();
}
function getProduct() {
    fetch(url)
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(datas => {
            index = 0;
            const htmls = datas.map(renderProduct);
            const html = htmls.join('');
            name.innerHTML = html;
        })
        .catch(error => console.error('Error fetching data:', error));
    
}

function renderProduct(data) {
    const stt = ++index;
    return `<tr>
                <th scope="row">${stt}</th>
                <td>${data.product_name}</td>
                <td><img src="../../${data.product_img}" alt="" style="max-width: 100px; max-height: 100px;"></td>
                <td>${data.product_sex}</td>
                <td>${data.product_price}</td>
                <td>${data.category_name}</td>
                <td>${data.brand_name}</td>
                
                <td>
                    <button class="btn btn-primary" onclick="handleUpdateProduct(${data.product_id})">Update</button>
                    <button class="btn btn-primary" onclick="handleDeleteProduct(${data.product_id})">Delete</button>
                </td>
            </tr>`;
}

function handleDeleteProduct(id) {
    const product_id = id;
    const product = {
        product_id: product_id
    };
    deleteProduct(product);
}
function deleteProduct(data) {
    const options = {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };
    fetch(url, options)
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(() => {
            getProduct(); 
        })
        .catch(error => console.error('Error deleting product:', error));
}


function renderProductByID(data,id){
    inputCategory.value = data[id-1].category_name;
    inputBrand.value = data[id-1].brand_name;
    inputName.value = data[id-1].product_name;
    inputSex.value = data[id-1].product_sex;
    inputPrice.value = data[id-1].product_price;
}
function getProductByID(id){
    let urlWithID = `${url}?id=${id}`;
    fetch(urlWithID)
    .then(function(res){
        return res.json();
    })
    .then(function(data){
        renderProductByID(data,id);
    })
    .catch(error => console.log(error));
}
let isCategoryAndBrandFetched = false;
function handleUpdateProduct(id){
    if (!isCategoryAndBrandFetched) {
        fetchCategoryAndBrand();
        isCategoryAndBrandFetched = true;
    }
    getProductByID(id);
    modal.classList.add('open');
    ID = id;
}
function updateProduct(data){
    let options = {
        method: 'PUT',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }
    fetch(url, options)
    .then(function(res){
        res.json();
    })
    .then(function(){
        getProduct();
    })
}

btnConfirmUpdate.addEventListener('click', function(){
    let product_id = ID;
    let product_name = document.querySelector('input[name="input-product_name"]').value;
    let product_price = document.querySelector('input[name="input-product_price"]').value;
    let product_sex = document.querySelector('input[name="input-product_sex"]').value;
    let category = document.querySelector('select[name="input-category"]').value; 
    let brand = document.querySelector('select[name="input-brand"]').value; 
    let product_img = inputImg.value;
    // let filename = product_img.split('\\').pop();
    let filename = product_img ? product_img.split('\\').pop() : "";
    let products = {
        product_id: product_id,
        category_id: category,
        brand_id: brand,
        product_name: product_name,
        // product_img: 'Assets/image/' + filename,
        product_img: product_img ? 'Assets/image/' + filename : "",
        product_sex: product_sex,
        product_price: product_price,
    };

    console.log(products);
    updateProduct(products);
    hiddenUpdateProduct();
});

function hiddenUpdateProduct(){
    modal.classList.remove('open');
}
function fetchCategoryAndBrand() {
    fetch('http://localhost/StoreToys-BE/API/category')
    .then(response => response.json())
    .then(categories => {
        const categorySelect = document.querySelector('select[name="input-category"]');
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.category_id;
            option.textContent = category.category_name;
            categorySelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error fetching categories:', error));
	
    fetch('http://localhost/StoreToys-BE/API/brand')
        .then(response => response.json())
        .then(brands => {
            const brandSelect = document.querySelector('select[name="input-brand"]');
            brands.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand.brand_id;
                option.textContent = brand.brand_name;
                brandSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching brands:', error));
}

