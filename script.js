const adminUsers = {
    "visitante09661@gmail.com": "972207",
    "visitante095772@gmail.com": "083962",
    "visitante028483@gmail.com": "976294",
    "visitante063774@gmail.com": "967304",
    "visitante938005@gmail.com": "053952",
    "despachantefreedomlcf@gmail.com": "123456",
    "Joaobatistarefrigeracao@gmail.com": "123456",
    "teste": "12345",
    "zapveicular@gmail.com": "123456",
    "visitante285": "125481",
    "visitante415": "102030",
    "visitante705": "102030",
    "visitante855": "102030",
    "visitante901": "102030",
    "visitante931": "102030",
    "visitante974": "102030",
    "visitante187": "102030",
    "visitante197": "102030",
    "visitante481": "102030",
    "visitante301": "102030"
};

// Função para verificar se o login é válido
function isValidAdmin(username, password) {
    return adminUsers[username] === password;
}

// Função para obter os usuários do localStorage
function getUsers() {
    return JSON.parse(localStorage.getItem('users')) || {}; // Retorna os usuários ou um objeto vazio caso não existam
}

// Função para salvar os usuários no localStorage
function saveUsers(users) {
    localStorage.setItem('users', JSON.stringify(users));
}

// Função para adicionar um usuário
function addUser(username, password) {
    const users = getUsers();
    users[username] = password;
    saveUsers(users);
}

// Função para remover um usuário
function removeUser(username) {
    const users = getUsers();
    delete users[username];
    saveUsers(users);
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const errorMessage = document.getElementById("error-message");

        // Obter resposta do CAPTCHA
        const captchaResponse = document.getElementById("captcha-response").value;
        if (!captchaResponse) {
            alert("Por favor, complete o CAPTCHA.");
            return;
        }

        // Verifica se o usuário é um dos administradores permitidos
        if (isValidAdmin(username, password)) {
            window.location.href = "AM.html"; // Redireciona para o painel de admin
        } 
        // Verifica se o usuário comum está cadastrado no localStorage
        else {
            const users = getUsers();
            if (users[username] && users[username] === password) {
                alert("Login bem-sucedido!");
                window.location.href = "AM.html"; // URL para usuários comuns
            } else {
                errorMessage.textContent = "Usuário ou senha inválidos!";
                errorMessage.style.color = "red";
            }
        }
    });

    // Função chamada pelo CAPTCHA quando resolvido
    window.onCaptchaSuccess = function (token) {
        document.getElementById("captcha-response").value = token;
    };

    // Expõe a função de adicionar e remover usuários globalmente
    window.addUser = addUser;
    window.removeUser = removeUser;
});
