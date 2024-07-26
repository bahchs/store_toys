
const url = 'http://localhost/StoreToys-BE/API/brand';
const name = document.getElementById('brand'); 
const modal = document.querySelector('.js-modal');
const inputBrandName = document.getElementById('brand-name'); 
const inputBrandImg = document.getElementById('brand-img'); 
const btnConfirmUpdate = document.getElementById('update'); 
var index = 0;
var ID = 0;

// Hàm bắt đầu
function start(){    
    getBrand();
}
start();

// Hàm lấy danh sách thương hiệu
function getBrand(){
    fetch(url)
    .then(function(res){
        return res.json();
    })  
    .then(function(datas) {
        index = 0;
        var htmls = datas.map(renderBrand);
        var html = htmls.join('');
        name.innerHTML = html;
    })
    .catch(error => console.log(error));
}

// Hàm hiển thị thông tin thương hiệu
function renderBrand(data){
    let stt = ++index;
    return `<tr>
                <th scope="row">${stt}</th>
                <td>${data.brand_name}</td>
                <td><img src="../../${data.brand_img}" alt="" style="max-width: 100px; max-height: 100px;"></td>
                <td>
                    <button class="btn btn-primary" onclick="handleUpdateBrand(${data.brand_id})">Update</button>
                    <button class="btn btn-primary" onclick="handleDeleteBrand(${data.brand_id})">Delete</button>
                </td>
            </tr>`;
}

// Hàm lấy thông tin thương hiệu theo ID
function getBrandByID(id){
    let urlWithID = `${url}?id=${id}`;
    fetch(urlWithID)
    .then(function(res){
        return res.json();
    })
    .then(function(datas){
        renderBrandByID(datas);
    })
    .catch(error => console.log(error));
}

// Hàm bắt đầu cập nhật thông tin thương hiệu
function handleUpdateBrand(id){
    getBrandByID(id);
    modal.classList.add('open');
    ID = id;
};

// Sự kiện click nút cập nhật
btnConfirmUpdate.addEventListener('click', function(){
        let brand_id = ID;
        let brand_name = inputBrandName.value;
        let brand_img = inputBrandImg.value;
        let brand = {
            brand_id: brand_id,
            brand_name: brand_name,
            brand_img: brand_img
        }
    updateBrand(brand);
    hiddenUpdateBrand();
    });

// Hàm cập nhật thông tin thương hiệu
function updateBrand(data){
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
        getBrand();
    })
}

// Hàm bắt đầu xóa thông tin thương hiệu
function handleDeleteBrand(id){
    let brand_id = id;
    let brand = {
        brand_id: brand_id
    }
    deleteBrand(brand);
}

// Hàm xóa thông tin thương hiệu
function deleteBrand(data){
    let options = {
        method: 'DELETE',
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
        getBrand();
    })
}

// Hàm ẩn modal cập nhật thương hiệu
function hiddenUpdateBrand(){
    modal.classList.remove('open');
}
