// Sistema de Gestión de Usuarios - CRUD en el lado del cliente
// Los datos se almacenan en localStorage del navegador
// En futuras etapas se implementará persistencia en base de datos

// Variables globales
let users = [];
let editingUserId = null;

// Función para cargar usuarios desde localStorage
function loadUsers() {
    const storedUsers = localStorage.getItem('users');
    if (storedUsers) {
        users = JSON.parse(storedUsers);
    }
}

// Función para guardar usuarios en localStorage
function saveUsers() {
    localStorage.setItem('users', JSON.stringify(users));
}

// Función para renderizar la tabla de usuarios
function renderTable() {
    const tableBody = document.getElementById('user-table-body');
    tableBody.innerHTML = '';

    users.forEach(user => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.phone || ''}</td>
            <td>
                <button class="action-btn edit-btn" data-id="${user.id}">Editar</button>
                <button class="action-btn delete-btn" data-id="${user.id}">Eliminar</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

// Función para agregar un nuevo usuario
function addUser(name, email, phone) {
    const newUser = {
        id: Date.now(), // Usamos timestamp como ID único
        name: name,
        email: email,
        phone: phone
    };

    users.push(newUser);
    saveUsers();
    renderTable();
}

// Función para actualizar un usuario existente
function updateUser(id, name, email, phone) {
    const userIndex = users.findIndex(user => user.id === id);
    if (userIndex !== -1) {
        users[userIndex].name = name;
        users[userIndex].email = email;
        users[userIndex].phone = phone;
        saveUsers();
        renderTable();
    }
}

// Función para eliminar un usuario
function deleteUser(id) {
    users = users.filter(user => user.id !== id);
    saveUsers();
    renderTable();
}

// Función para cargar datos del usuario en el formulario para edición
function loadUserForEdit(id) {
    const user = users.find(user => user.id === id);
    if (user) {
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('phone').value = user.phone || '';
        editingUserId = id;
        document.getElementById('cancel-edit').style.display = 'inline-block';
        document.querySelector('button[type="submit"]').textContent = 'Actualizar Usuario';
    }
}

// Función para cancelar la edición
function cancelEdit() {
    document.getElementById('user-form').reset();
    editingUserId = null;
    document.getElementById('cancel-edit').style.display = 'none';
    document.querySelector('button[type="submit"]').textContent = 'Agregar Usuario';
}

// Event listener para el envío del formulario
document.getElementById('user-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    if (editingUserId) {
        // Actualizar usuario existente
        updateUser(editingUserId, name, email, phone);
        cancelEdit();
    } else {
        // Agregar nuevo usuario
        addUser(name, email, phone);
        this.reset();
    }
});

// Event listener para el botón de cancelar edición
document.getElementById('cancel-edit').addEventListener('click', cancelEdit);

// Event listener para los botones de editar y eliminar (usando delegación de eventos)
document.getElementById('user-table-body').addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-btn')) {
        const userId = parseInt(e.target.getAttribute('data-id'));
        loadUserForEdit(userId);
    } else if (e.target.classList.contains('delete-btn')) {
        const userId = parseInt(e.target.getAttribute('data-id'));
        if (confirm('¿Está seguro de que desea eliminar este usuario?')) {
            deleteUser(userId);
        }
    }
});

// Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    renderTable();
});
