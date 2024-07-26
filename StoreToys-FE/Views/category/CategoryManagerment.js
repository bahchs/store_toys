// JavaScript Document
const url = 'http://localhost/StoreToys-BE/API/category';
const name = document.getElementById('category');
const modal = document.querySelector('.js-modal');
const inputCategory = document.getElementById('category-name');
const btnConfirmUpdate = document.getElementById('update');
var index = 0;
var ID = 0;

function start(){	
	getCategory();
}
start();
function getCategory(){
	fetch(url)
	.then(function(res){
		return res.json();
	})	
	.then(function(datas) {
		index = 0;
		var htmls = datas.map(renderCategory);
		var html = htmls.join('');
		name.innerHTML = html;
	})
	.catch(error => console.log(error));
}
function renderCategory(data){
	let stt = ++index;
	return `<tr>
				<th scope="row">${stt}</th>
				<td>${data.category_name}</td>
				<td>
					<button class="btn btn-primary" onclick="handleUpdateCategory(${data.category_id})">Update</button>
					<button class="btn btn-primary" onclick="handleDeleteCategory(${data.category_id})">Delete</button>
				</td>
			</tr>`;
}
function renderCategoryByID(data){
	inputCategory.value = data[0].category_name;
}
function getCategoryByID(id){
	let urlWithID = `${url}?id=${id}`;
	fetch(urlWithID)
	.then(function(res){
		return res.json();
	})
	.then(function(datas){
		renderCategoryByID(datas);
	})
	.catch(error => console.log(error));
}

function handleUpdateCategory(id){
	getCategoryByID(id);
	modal.classList.add('open');
	ID = id;
};

btnConfirmUpdate.addEventListener('click', function(){
		let category_id = ID;
		let category_name = document.querySelector('input[name="input-category-name"]').value;
		let category = {
			category_id: category_id,
			category_name: category_name
		}
	updateCategory(category);
	hiddenUpdateCategory();
	});

function updateCategory(data){
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
		getCategory();
	})
}
function handleDeleteCategory(id){
	let category_id = id;
	let category = {
		category_id: category_id
	}
	deleteCategory(category);
}
function deleteCategory(data){
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
		getCategory();
	})
}

function hiddenUpdateCategory(){
	modal.classList.remove('open');
}