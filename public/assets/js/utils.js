
// función para manejar las rutas
function route(name, params = {}) {
    let url = routes[name];
    for (let param in params) {
        url = url.replace(`:${param}`, params[param]);
    }
    return url;
}