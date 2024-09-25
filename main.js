function toggleSidebar(){
    document.getElementById('toggle-sidebar').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    });     
}
function handleInput(event) {
    const input = document.getElementById('console-input');
    const output = document.getElementById('console-output');

    // Detectar la tecla "Enter"
    if (event.key === 'Enter') {
        event.preventDefault(); // Evitar el salto de línea

        const inputText = input.value.trim();

        if (inputText) {
            const commandElement = document.createElement('div');
            commandElement.classList.add('command');
            commandElement.textContent = `nombre_de_usuario@nivel:~$ ${inputText}`;

            output.appendChild(commandElement);  // Agregar el comando a la salida

            // Limpiar el campo de entrada
            input.value = '';

            // Asegurar que haga scroll hacia abajo
            output.scrollTop = output.scrollHeight;
        }

        // Devolver el foco al input para seguir escribiendo
        input.focus();
    }
}
function redirectToPage(page) {
    let url = '';
    switch (page){
        case 'XSS':
            url = "XSS.html"
        break;
        case 'SQL':
            url = "SQL_Injection.html"
        break;
        case 'login':
            url = "index.html"
        break;
    }
    window.location= url;
}
function goBack(){
    document.getElementById("goBackButton").addEventListener("click", function() {
        window.history.back();
    });
}
