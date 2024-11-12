// Toggle the sidebar
function toggleSidebar() {
    const sidebar = document.querySelector('#sidebar');
    sidebar.classList.toggle('active');
}

// Redirect to specific page
function redirectToPage(page) {
    let url = "";

    switch (page) {
        case 'XSS':
            url = "XSS/index.php";
            break;
        case 'SQL':
            url = "SQL_Injection.php";
            break;
        default:
            console.warn("Unknown page:", page);
            return;
    }

    window.location = url;
}

function goBack() {
    const currentUrl = window.location.pathname;
    if (currentUrl.includes("product/product.php")) {
        // Redirige a home si la URL actual contiene "XSS/index"
        window.location.href = "../index.php?modulo=home";
    } else {
        // De lo contrario, vuelve a la página anterior
        history.back();
    }
}

