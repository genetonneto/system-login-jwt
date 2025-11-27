export function handleLogin() {
    const BASE_URL = 'http://localhost:8000/';
    const formLogin = document.querySelector('#formLogin');
    if (!formLogin) return;

    formLogin.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(formLogin);
        const { data } = await axios.post(BASE_URL + 'backend/src/auth/login.php', formData);
        // console.log('Login: ', data);

        sessionStorage.setItem('session', data);

        if (data.Success) {
            window.location.href = data.redirect;
        }
    });

}