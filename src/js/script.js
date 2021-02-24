let aplicar = document.getElementById('aplicar');

/*Adicionar novo*/
let query = location.search.slice(1);
let partes = query.split('&');
data = {};
partes.forEach(parte => {
  let chaveValor = parte.split('=');
  let chave = chaveValor[0];
  let valor = chaveValor[1];
  data[chave] = valor;
})

let add = document.getElementById('add');
let table = document.getElementById('games_table');

if(data.secao === 'jogos') {
  add.addEventListener('click', () => {
    let table_row = document.createElement('tr');
    let table_body = document.getElementById('tbody');
    let inputs = [];
    inputs = ['capa', 'id', 'titulo', 'preco', 'lancamento', 'descricao', 'produtora', 'categoria'];
    

    for(let i = 0; i < inputs.length; i++) {
      let table_data = document.createElement('td');

      if(inputs[i] === 'capa') {
        let inputFile = document.createElement('input');
        inputFile.setAttribute('name', 'capa');
        inputFile.setAttribute('type', 'file');
        table_data.appendChild(inputFile);
        table_row.appendChild(table_data);

      } else {
        let input = document.createElement('input');
        input.setAttribute('name', inputs[i]);
        input.setAttribute('type', 'text');
        table_data.appendChild(input);
        table_row.appendChild(table_data); 
      }
    }

    table_body.appendChild(table_row);

  });
}

// Atualizar
let inputsTable = document.querySelectorAll('td input');
inputsTable.forEach(inputTable => {
  inputTable.addEventListener('change', () => {

    // pega o nó parente do elemento que sofreu o evento
    let td = inputTable.parentNode;
    let id = td.parentNode.querySelector('#id'); 
    
    id.setAttribute("name", "atualizar_id");

    inputTable.setAttribute('name', 'atualizar_'+inputTable.id);
  })
})

// Deletar
let removeButton = document.querySelectorAll('tr td button');
let i = 0;//preciso gerar names diferentes para conseguir deletar quantos eu quiser
removeButton.forEach(btn => {
  btn.addEventListener('click', () => {

    // pega o nó parente do elemento que sofreu o evento
    let td = btn.parentNode;
    let id = td.parentNode.querySelector('#id'); 
    
    id.setAttribute("name", "deletar_id"+i);
    console.log(id);
    i++
  })
})


// Dropdown
let menu = document.querySelector('nav ul li a');
let container = document.getElementsByClassName('container');
let span = document.querySelector("nav ul li a img:nth-child(2)");

let clicked = false;
menu.addEventListener('click', (event) => {
  let dropdown = document.getElementById("content_menu_icon");
  container[0].addEventListener('click', (event) => {
    if (event.target !== dropdown) {
      dropdown.style.display = 'none';
      span.style.animation = "rotateOut 0.2s ease-in both";
      clicked = false;
    }
  })
  if(!clicked) {
    dropdown.style.display = "block";
    span.style.animation = "rotateIn 0.2s ease-in both";
    clicked = true;
  } else if(clicked) {
    dropdown.style.display = "none";
    span.style.animation = "rotateOut 0.2s ease-in both";
    clicked = false;
  }
});

/*
//Máscara de preço
let preco = document.getElementsById('input');
preco.addEventListener('change', () => {

})
*/