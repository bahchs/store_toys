// JavaScript Document
const userUrl = 'http://localhost/StoreToys-BE/API/user';
const inputName = document.querySelector(".box-name");
const inputPhone = document.querySelector(".box-phone");
const inputAddress = document.querySelector(".box-adrress");
const inputSex = document.querySelector(".box-sex");
const inputEmail = document.querySelector(".box-email");
const updateBtn = document.querySelector(".btn");
start();
function start(){
	getProfile();
}
function getProfile(){
	fetch(`${userUrl}?id=${userId}`)
	.then(function(res){
		return res.json();
	})
	.then(function(datas){
		renderProfile(datas);
	})
}
function renderProfile(data){
	inputName.value = data[0].fullname;
	inputPhone.value = data[0].phone;
	inputAddress.value = data[0].address;
	inputSex.value = data[0].sex;
	inputEmail.value = data[0].email;
}
updateBtn.addEventListener("click", function(){
	let username = user.username;
	let password = user.password;
	let role = user.role;
	let newName = inputName.value;
	let newPhone = inputPhone.value;
	let newAddress = inputAddress.value;
	let newSex = inputSex.value;
	let newEmail = inputEmail.value;
	let userProfile = {
		user_id: userId,
		username: username,
        password: password,
		fullname: newName,
		phone: newPhone,
		address: newAddress,
		sex: newSex,
		email: newEmail,
		role: role
	}
	updateProfile(userProfile);
})
function updateProfile(profile){
	let option = {
		method: 'PUT',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(profile)
	}
	fetch(userUrl, option)
	.then(function(res){
        res.json();
    })
    .then(function(){
        window.location.reload();
    })
	.catch(error => console.error(error));
}