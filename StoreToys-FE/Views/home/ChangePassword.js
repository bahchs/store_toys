// JavaScript Document
const userUrl = 'http://localhost/StoreToys-BE/API/user';
const inputOldPass = document.querySelector(".box-old-password");
const inputNewPass = document.querySelector(".box-new-password");
const inputRetypePass = document.querySelector(".box-retype-password");
const updateBtn = document.querySelector(".btn");

updateBtn.addEventListener("click", function(){
    const storedCurrentPassword = user.password;
	if (inputOldPass.value.trim() === '') {
        alert('Vui lòng nhập mật khẩu cũ.');
        return;
    }
	let currentPassword = inputOldPass.value;
    if (currentPassword !== storedCurrentPassword) {
            alert('Mật khẩu cũ không chính xác.');
            return;
    }
	if (inputNewPass.value.trim() === '') {
        alert('Vui lòng nhập mật khẩu mới.');
        return;
    }
	const newPass = inputNewPass.value;
	const user_id = user.user_id;
	const username = user.username;
	const fullname = user.fullname;
	const sex = user.sex;
	const address = user.address;
	const phone = user.phone;
	const email = user.email;
	const role = user.role;
	
	const data = {
            user_id: user_id,
            fullname: fullname,
            sex: sex,
            address: address,
            phone: phone,
            email: email,
            username: username,
            password: newPass,
            role: role
        };
	updatePass(data);
})
function updatePass(data){
	let option = {
		method: 'PUT',
        headers:{
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
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