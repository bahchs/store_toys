// JavaScript Document
const url = 'http://localhost/StoreToys-BE/API/product';

function start() {
    handleCreateForm();
    fetchCategoriesAndBrands();
}

start();

function createProduct(data) {
    let options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }
    fetch(url, options)
	.then(function(res){
		return res.json();
	})
	.then(function(datas){
		console.log(datas);
        window.location.href = "http://localhost/StoreToys-FE/Views/product/ProductManagerment.html";
	})
}

function handleCreateForm() {
    let createBtn = document.getElementById('btnSubmit');
    createBtn.onclick = function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của nút gửi
        
        let product_name = document.querySelector('input[name="product_name"]').value;
        let product_image = document.querySelector('input[name="product_image"]').files[0];
        let imageURL ='Assets/image/' + product_image.name;
        let product_sex = document.querySelector('input[name="product_sex"]').value;
        let product_price = document.querySelector('input[name="product_price"]').value;
        let category_id = document.querySelector('select[name="category_id"]').value; 
        let brand_id = document.querySelector('select[name="brand_id"]').value; 
        let product = {
            category_id: category_id,
            brand_id: brand_id,
            product_name: product_name,
            product_img: imageURL,
            product_sex: product_sex,
            product_price: product_price
        };
        console.log(product);
        createProduct(product);
    };
}

function fetchCategoriesAndBrands() {
    fetch('http://localhost/StoreToys-BE/API/category')
        .then(response => response.json())
        .then(categories => {
           
            const categorySelect = document.querySelector('select[name="category_id"]');
            categories.forEach(category => {
              console.log(category)
                const option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.category_name;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));

    fetch('http://localhost/StoreToys-FE/API/brand')
        .then(response => response.json())
        .then(brands => {
            const brandSelect = document.querySelector('select[name="brand_id"]');
            brands.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand.brand_id;
                option.textContent = brand.brand_name;
                brandSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching brands:', error));
}



