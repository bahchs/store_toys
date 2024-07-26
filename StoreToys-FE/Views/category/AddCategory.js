// JavaScript Document
const url = 'http://localhost/StoreToys-BE/API/category';
function start(){
	handleCreateForm();
}
start();
function createCategory(data){
	let options = {
		method: 'POST',
		headers:{
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
		window.location.href = "http://localhost/StoreToys-FE/Views/category/CategoryManagerment.html";
	})
}
function handleCreateForm(){
	let createBtn = document.getElementById('btnSubmit');
	createBtn.onclick = function(){
		let name = document.querySelector('input[name="category_name"]').value;
		let category = {
			category_name: name
		}
		console.log(category);
		createCategory(category);
	}
}