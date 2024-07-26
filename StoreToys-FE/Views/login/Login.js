const url = 'http://localhost/StoreToys-BE/API/Login';

function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    if (username.trim() === '' || password.trim() === '') {
        alert('Vui lòng nhập đầy đủ tài khoản và mật khẩu.');
        return;
    }
    const data = {
        username: username,
        password: password
    };

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch(url, options)
        .then(response => response.json())
        .then(user => {
            if (user.message) {
                alert(user.message);
            } else {
                localStorage.setItem('user', JSON.stringify(user));
                const storedUser = JSON.parse(localStorage.getItem('user'));
                console.log(storedUser.user_id);
                if (storedUser.username === 'admin') {
                    window.location.href = 'http://localhost/StoreToys-FE/Views/product/ProductManagerment.html';
                } else {
                    window.location.href = 'http://localhost/StoreToys-FE/Views/home/Home.html';
                }
            }
        })
        .catch(error => console.error(error));
}
