export function handleRegister() {
    const BASE_URL = 'http://localhost:8000/';
    const formRegister = document.querySelector('#formRegister');
    if (!formRegister) return;

    formRegister.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(formRegister);
        const { data } = await axios.post(BASE_URL + 'backend/src/auth/register.php', formData);
        console.log('Register: ', data);

        if (data.success) {
            window.location.href = data.redirect;
        }
    });
}