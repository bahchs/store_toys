const url = 'http://localhost/StoreToys-BE/API/brand';

function start() {
    handleCreateForm();
}

start();

function createBrand(data) {
    let options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };
    
    fetch(url, options)
    .then(function(res) {
        return res.json();
    })
    .then(function(datas) {
        console.log(datas);
        // Chuyển hướng về trang quản lý thương hiệu sau khi thêm thành công
        window.location.href = "http://localhost/StoreToys-FE/Views/brand/BrandManagerment.html";
    })
    .catch(function(error) {
        console.log(error);
    });
}

function handleCreateForm() {
    let createBtn = document.querySelector('button[name="submit"]');
    createBtn.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của nút submit
        let name = document.querySelector('input[name="brand_name"]').value;
        let image = document.querySelector('input[name="brand_img"]').files[0]; // Lấy file hình ảnh thương hiệu
        
        // Kiểm tra xem người dùng đã chọn hình ảnh hay chưa
        if (image) {
            let formData = new FormData();
            formData.append('brand_name', name);
            formData.append('brand_img', image);
            
            // Gọi hàm tạo thương hiệu với dữ liệu đã được chọn
            createBrand(formData);
        } else {
            alert('Vui lòng chọn hình ảnh');
        }
    });
}
