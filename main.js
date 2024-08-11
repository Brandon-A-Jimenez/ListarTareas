const input = document.querySelector("input");
const addBtn = document.querySelector(".btn-add");
const ul = document.querySelector("ul");
const empty = document.querySelector(".empty");

document.addEventListener("DOMContentLoaded", loadTasks);

// Cargar las tareas desde la base de datos cuando se carga la página
function loadTasks() {
    fetch('server.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(task => {
                addTaskToList(task.task, task.id);
            });

            if (data.length > 0) {
                empty.style.display = "none";
            }
        });
}

// Agregar tarea
addBtn.addEventListener("click", (e) => {
  e.preventDefault();

  const text = input.value;

  if (text !== "") {
    // Enviar la tarea al servidor
    fetch('server.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `task=${encodeURIComponent(text)}`
    })
    .then(response => response.json())
    .then(data => {
        // Agregar la tarea y guardarla en el DB
        addTaskToList(text, data.insertId); // Usar el ID devuelto por el servidor
    });

    input.value = "";
  }
});

// Función para agregar la tarea al DOM
function addTaskToList(taskText, taskId = null) {
    const li = document.createElement("li");
    const p = document.createElement("p");
    p.textContent = taskText;

    li.appendChild(p);
    li.appendChild(addDeleteBtn(taskId));
    ul.appendChild(li);

    empty.style.display = "none";
}

// Crear el botón de eliminar
function addDeleteBtn(taskId) {
  const deleteBtn = document.createElement("button");

  deleteBtn.textContent = "X";
  deleteBtn.className = "btn-delete";

  deleteBtn.addEventListener("click", (e) => {
    const item = e.target.parentElement;
    ul.removeChild(item);

    // Eliminar la tarea de la base de datos
    if (taskId) {
        fetch('server.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `delete_id=${taskId}`
        }).then(response => {
            return response.text();
        }).then(data => {
            console.log(data); // Para verificar la respuesta del servidor
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    const items = document.querySelectorAll("li");

    if (items.length === 0) {
      empty.style.display = "block";
    }
  });

  return deleteBtn;
}
