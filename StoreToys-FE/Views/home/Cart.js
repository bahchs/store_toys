const categoryUrl = 'http://localhost/StoreToys-BE/API/category';
const brandUrl = 'http://localhost/StoreToys-BE/API/brand';
const categoryItem = document.getElementById("category-name");
const brandItem = document.getElementById("brand-name");
const cartContainer = document.querySelector(".cart-container");
const totalQuantity = document.getElementById('totalQuantity');
const totalPrice = document.getElementById('totalPrice');
const profile = document.querySelector(".fa-user-circle");
const numberCart = document.querySelector(".number-product");
var index = 0;
const user = JSON.parse(localStorage.getItem('user')); 
const userId = user ? user.user_id : null; 
const cartUrl = `http://localhost/StoreToys-BE/API/cart?user_id=${userId}`;
const urlParams = new URLSearchParams(window.location.search);
const brandName = urlParams.get('brand_name');

const searchForm = document.querySelector(".search-form");

window.onload = function() {
    getCategory();
    getBrand();
    getQuantityCart();
	getCartItems();
	openProfile();
    let cartItems = []; 
    let sumQuantity = 0;
    let sumPrice = 0;
    
	function getCartItems(){
		fetch(cartUrl) 
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                cartItems = data;
                data.forEach(item => {
                    sumQuantity += item.quantity;
                    sumPrice += parseInt(item.product_price);
                });

                renderCartItems(sumPrice);
                
            } else {
                renderCarEmpty();
            }
        })
        .catch(error => console.error('Error:', error));
	}

    function performSearch(event) {
        event.preventDefault();
        const searchInput = document.querySelector(".search-input");
        const searchTerm = searchInput.value;
        window.location.href = `Search.html?search=${encodeURIComponent(searchTerm)}`;
    }
    searchForm.addEventListener("submit", performSearch);
    
    function getCategory(){
        fetch(categoryUrl)
        .then(res => res.json())
        .then(datas => {
            var htmls = datas.map(renderCategory);
            var html = htmls.join('');
            categoryItem.innerHTML = html;
        })
        .catch(error => console.log(error));
    }
    
    function renderCategory(data){
        return ` <li class="list-content hover-region">
                     <a href="" class="content">${data.category_name}</a>
                 </li>`;
    }
    
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

    function renderBrand(data) {
        const encodedBrandName = encodeURIComponent(data.brand_name);
        return `<li class="list-content hover-region">
                  <a href="Brand.html?brand_name=${encodedBrandName}" class="content">${data.brand_name}</a>
                </li>`;
    }
    
    function getQuantityCart(){
        fetch(cartUrl)
        .then(res => res.json())
        .then(datas => {
            let quantityCart = datas.length;
            renderQuantityCart(quantityCart);
        })
        .catch(error => console.log(error));
    }

    function renderQuantityCart(quantity){
        numberCart.textContent = `(${quantity})`;    
    }
    
    function renderCarEmpty(){
        const cartEmpty = document.createElement('div');
        cartEmpty.classList.add('cart-empty');
        const emptyImg = document.createElement('img');
        emptyImg.src = '../../Assets/image/no-cart.png';
        const cartNotify = document.createElement('div');
        cartNotify.textContent = 'Giỏ hàng của bạn đang trống';
        const homeBtn = document.createElement('a');
        homeBtn.href = 'Home.html';
        homeBtn.textContent = 'Tiếp tục mua hàng';
        cartEmpty.appendChild(emptyImg);
        cartEmpty.appendChild(cartNotify);
        cartEmpty.appendChild(homeBtn);
        cartContainer.appendChild(cartEmpty);
    }
    
    function renderCartItems(sumPrice) {   
		cartContainer.innerHTML = ''; 
        const cartTable = document.createElement('table');
        cartTable.border = 2;
        const cartInfor = document.createElement('tr');
        
        const cartIndex = document.createElement('th');
        cartIndex.classList.add('product-number', 'product-title');
        cartIndex.textContent = 'STT';
        
        const cartName = document.createElement('th');
        cartName.classList.add('product-name', 'product-title');
        cartName.textContent = 'Tên sản phẩm';
        
        const cartImg = document.createElement('th');
        cartImg.classList.add('product-img', 'product-title');
        cartImg.textContent = 'Ảnh';
        
        const cartPrice = document.createElement('th');
        cartPrice.classList.add('product-price', 'product-title');
        cartPrice.textContent = 'Đơn giá';
        
        const cartQuantity = document.createElement('th');
        cartQuantity.classList.add('product-quantity', 'product-title');
        cartQuantity.textContent = 'Số lượng';
        
        const cartMoney = document.createElement('th');
        cartMoney.classList.add('product-money', 'product-title');
        cartMoney.textContent = 'Thành tiền';
        
        const cartOption = document.createElement('th');
        cartOption.classList.add('product-delete', 'product-title');
        cartOption.textContent = 'Tùy chọn';
        
        cartInfor.appendChild(cartIndex);
        cartInfor.appendChild(cartName);
        cartInfor.appendChild(cartImg);
        cartInfor.appendChild(cartPrice);
        cartInfor.appendChild(cartQuantity);
        cartInfor.appendChild(cartMoney);
        cartInfor.appendChild(cartOption);
        cartTable.appendChild(cartInfor);
        
        cartItems.forEach(item => {
            const cartList = document.createElement('tr');
            index++;
            const productIndex = document.createElement('td');
            productIndex.classList.add('product-number');
            productIndex.textContent = index;

            const productName = document.createElement('td');
            productName.classList.add('product-name');
            productName.textContent = `${item.product_name}`;
            
            const productImg = document.createElement('td');
            const img = document.createElement('img');
            productImg.classList.add('product-img');
            img.src = `../../${item.product_img}`;
            productImg.appendChild(img);

            const productPrice = document.createElement('td');
            productPrice.classList.add('product-price');
            productPrice.textContent = `${item.product_price} VNĐ`;
            
            const productQuantity = document.createElement('td');
            const inputQuantity = document.createElement('input');
            productQuantity.classList.add('product-quantity');
            inputQuantity.type = 'text';
            inputQuantity.value = `${item.quantity}`;
            inputQuantity.dataset.productId = item.product_id; // Lưu productId vào dataset
            productQuantity.appendChild(inputQuantity);
            
            const productMoney = document.createElement('td');
            productMoney.classList.add('product-price');
            let money = item.product_price * item.quantity;
            productMoney.textContent = `${money} VNĐ`;

            const productOption = document.createElement('td');
            productOption.classList.add('product-delete');
            productOption.dataset.productId = item.product_id; // Lưu productId vào dataset
            productOption.dataset.productPrice = item.product_price; // Lưu productPrice vào dataset
            const btnDelete = document.createElement('button');
            btnDelete.textContent = 'Xóa sản phẩm';
			btnDelete.classList.add('delete-button');
            productOption.appendChild(btnDelete);

            cartList.appendChild(productIndex);
            cartList.appendChild(productName);
            cartList.appendChild(productImg);
            cartList.appendChild(productPrice);
            cartList.appendChild(productQuantity);
            cartList.appendChild(productMoney);
            cartList.appendChild(productOption);
            cartTable.appendChild(cartList);
        });
        
        const totalTR = document.createElement('tr');
        const emptyTH = document.createElement('th');
        emptyTH.classList.add('product-number', 'product-title');
        const totalMoney = document.createElement('th');
        totalMoney.classList.add('product-number', 'product-title');
        totalMoney.colSpan = 6;
        totalMoney.textContent = `Tổng tiền: ${sumPrice} VNĐ`;
        
        const cartMessage = document.createElement('div');
        cartMessage.style.marginTop = '15px';
        const updateMessage = document.createElement('i');
        updateMessage.classList.add('update_cart');
        updateMessage.textContent = '*Chú ý: Thượng đế hãy cập nhật lại giỏ hàng mỗi lần sửa số lượng. SToys xin cảm ơn!';
        const btnUpdate = document.createElement('button');
        btnUpdate.classList.add('update_cart-button');
        btnUpdate.textContent = 'Cập nhật giỏ hàng';
        
        const payment = document.createElement('div');
        payment.classList.add('cart-empty');
        payment.style.marginTop = '50px';
        const paymentBtn = document.createElement('a');
        paymentBtn.href = `pay.html?totalMoney=${sumPrice}`;
        paymentBtn.textContent = 'Tiến hành thanh toán';
        payment.appendChild(paymentBtn);
        
        cartMessage.appendChild(updateMessage);
        cartMessage.appendChild(btnUpdate);
        
        totalTR.appendChild(emptyTH);
        totalTR.appendChild(totalMoney);
        cartTable.appendChild(totalTR);
        
        cartContainer.appendChild(cartTable);
        cartContainer.appendChild(cartMessage);
        cartContainer.appendChild(payment);
    }

    function updateCartItem(userId, id, newQuantity) {
		fetch(`http://localhost/StoreToys-BE/API/cart?id=${id}&user_id=${userId}`, {
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ quantity: newQuantity }) 
		})
		.then(response => response.json())
		.then(data => {
			const updatedCartItems = cartItems.filter(item => item.product_id !== id);
			console.log(cartItems.filter(item => item.product_id === id))
			cartItems = updatedCartItems;
	
			sumQuantity--;
			sumPrice -= parseInt(productPrice);
	
			if (totalQuantity && totalPrice) {
				totalQuantity.textContent = sumQuantity;
				totalPrice.textContent = sumPrice.toLocaleString('vi-VN') + ' VNĐ';
			}
	
			renderCartItems();
		})
		.catch(error => console.error('Error:', error));
	}
	
	function removeCartItem(userId, id, productPrice) {
		fetch(`http://localhost/StoreToys-BE/API/cart?id=${id}&user_id=${userId}`, {
			method: 'DELETE'
		})
		.then(response => response.json())
		.then(data => {
			// const updatedCartItems = cartItems.filter(item => item.product_id !== id);
			// console.log(cartItems.filter(item => item.product_id === id))
			// cartItems = updatedCartItems;
			sumPrice -= parseInt(productPrice);
			getCartItems();
		})
		.catch(error => console.error('Error:', error));
	}

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('update_cart-button')) {
            const inputs = document.querySelectorAll('.product-quantity input');
            inputs.forEach(input => {
                const id = input.dataset.productId;
                const newQuantity = parseInt(input.value);
                updateCartItem(id, newQuantity);
            });
        }

        if (event.target.classList.contains('delete-button')) {
			const id = event.target.parentElement.dataset.productId; 
			const productPrice = event.target.parentElement.dataset.productPrice; 
			console.log("id:", id);
			console.log("productPrice:", productPrice);
			removeCartItem(userId, id, productPrice);
		}
		
    });
	function openProfile(){
        if(userId != null){
            profile.href = "Profile.html";
        } else{
            profile.href = "../login/Login.html";
        }
    }
};
