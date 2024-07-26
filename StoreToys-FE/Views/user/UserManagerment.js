// JavaScript Document
const url = 'http://localhost/StoreToys-BE/API/user';
const userList = document.getElementById('user-list');
const modal = document.querySelector('.js-modal');
const inputUsername = document.getElementById('username');
const inputPassword = document.getElementById('password');
const inputFullname = document.getElementById('fullname');
const inputEmail = document.getElementById('email');
const inputPhone = document.getElementById('phone');
const inputAddress = document.getElementById('address');
const inputGender = document.getElementById('sex');
const inputRole = document.getElementById('role');
const btnConfirmUpdate = document.getElementById('update');
var index = 0;
var ID = 0;

function start(){   
    getUsers();
}
start();

function getUsers(){
    fetch(url)
    .then(function(res){
        return res.json();
    })  
    .then(function(datas) {
        index = 0;
        var htmls = datas.map(renderUser);
        var html = htmls.join('');
        userList.innerHTML = html;
    })
    .catch(error => console.log(error));
}

function renderUser(data){
    let stt = ++index;
    return `<tr>
                <th scope="row">${stt}</th>
                <td>${data.username}</td>
                <td>${data.password}</td>
                <td>${data.fullname}</td>
                <td>${data.email}</td>
                <td>${data.phone}</td>
                <td>${data.address}</td>
                <td>${data.sex}</td>
                <td>${data.role == 1 ? 'Admin' : 'Người dùng'}</td>
                <td>
                    <button class="btn btn-primary" onclick="handleUpdateUser(${data.user_id})">Update</button>
                    <button class="btn btn-primary" onclick="handleDeleteUser(${data.user_id})">Delete</button>
                </td>
            </tr>`;
}

function renderUserByID(data){
    inputUsername.value = data[0].username;
    inputPassword.value = data[0].password;
    inputFullname.value = data[0].fullname;
    inputEmail.value = data[0].email;
    inputPhone.value = data[0].phone;
    inputAddress.value = data[0].address;
    inputGender.value = data[0].sex;
    inputRole.value = data[0].role;
}

function getUserByID(id){
    let urlWithID = `${url}?id=${id}`;
    fetch(urlWithID)
    .then(function(res){
        return res.json();
    })
    .then(function(datas){
        renderUserByID(datas);
    })
    .catch(error => console.log(error));
}

function handleUpdateUser(id){
    getUserByID(id);
    modal.classList.add('open');
    ID = id;
}

btnConfirmUpdate.addEventListener('click', function(){
    let user_id = ID;
    let username = inputUsername.value;
    let password = inputPassword.value;
    let fullname = inputFullname.value;
    let email = inputEmail.value;
    let phone = inputPhone.value;
    let address = inputAddress.value;
    let sex = inputGender.value;
    let role = inputRole.value;
    let user = {
        user_id: user_id,
        username: username,
        password: password,
        fullname: fullname,
        email: email,
        phone: phone,
        address: address,
        sex: sex,
        role: role
    }
    updateUser(user);
    hiddenUpdateUser();
});

function updateUser(data){
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
        getUsers();
    })
}

function handleDeleteUser(id){
    let user_id = id;
    let user = {
        user_id: user_id
    }
    deleteUser(user);
}

function deleteUser(data){
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
        getUsers();
    })
}

function hiddenUpdateUser(){
    modal.classList.remove('open');
}
// JavaScript Document