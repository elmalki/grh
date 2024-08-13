
export default function getConnectedUser(){
    return JSON.parse(document.getElementById('user_info').textContent);
}