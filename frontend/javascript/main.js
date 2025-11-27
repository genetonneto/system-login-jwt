import { handleRegister } from './formRegister.js';
import { handleLogin } from './formLogin.js';

document.addEventListener('DOMContentLoaded', () => {
    handleRegister();
    handleLogin();
});