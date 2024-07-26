// JavaScript Document
const url = 'http://localhost/StoreToys-BE/API/user';

function start(){
	handleCreateForm();
}

start();

function createUser(data){
	let options = {
		method: 'POST',
		headers:{
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	};
	fetch(url, options)
	.then(function(res){
		return res.json();
	})
	.then(function(datas){
		console.log(datas);
		window.location.href = "http://localhost/StoreToys-FE/Views/user/UserManagerment.html";
	})
}

function handleCreateForm(){
    let form = document.getElementById('userForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        let username = document.querySelector('input[name="username"]').value;
        let password = document.querySelector('input[name="password"]').value;
        let fullname = document.querySelector('input[name="fullname"]').value;
        let email = document.querySelector('input[name="email"]').value;
        let phone = document.querySelector('input[name="phone"]').value;
        let address = document.querySelector('input[name="address"]').value;
        let gender = document.querySelector('select[name="sex"]').value;
        let role = document.querySelector('select[name="role"]').value;

        let user = {
            username: username,
            password: password,
            fullname: fullname,
            email: email,
            phone: phone,
            address: address,
            sex: gender,
            role: role
        };
		console.log(user);
        createUser(user);
    });
}

