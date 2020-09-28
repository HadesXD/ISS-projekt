/*
** modal.js
** original code by: https://github.com/WebDevSimplified/Vanilla-JavaScript-Modal
*/

const openModalButtons = document.querySelectorAll('[data-modal-target]')
const closeModalButtons = document.querySelectorAll('[data-close-button]')
const overlay = document.getElementById('overlay')

openModalButtons.forEach(button => {
  button.addEventListener('click', () => {
    const modal = document.querySelector(button.dataset.modalTarget)
    openModal(modal)
  })
})

overlay.addEventListener('click', () => {
  const modals = document.querySelectorAll('.modal.active')
  modals.forEach(modal => {
    closeModal(modal)
  })
})

closeModalButtons.forEach(button => {
  button.addEventListener('click', () => {
    const modal = button.closest('.modal')
    closeModal(modal)
  })
})

// default function for opening the modal with empty values
function openModal(modal) {
  document.querySelector("#action_type").value = "insert";

  if (modal == null) return
  modal.classList.add('active')
  overlay.classList.add('active')
}

// default function for opening the modal with empty values
function editProfileModal(modal, first_name, last_name, email) {
  document.querySelector("#action_type").value = "insert";
  
  document.querySelector("#first_name").value = first_name;
  document.querySelector("#last_name").value = last_name;
  document.querySelector("#email").value = email;

  if (modal == null) return
  modal.classList.add('active')
  overlay.classList.add('active')
}

// function that opens the modal with prefilled inforamtion
function editModal(modal, id_event, event_name, event_type, event_limit) {
  document.querySelector("#id_event").value = id_event;
  document.querySelector("#event_name").value = event_name;
  document.querySelector("#event_type").value = event_type;
  document.querySelector("#event_limit").value = event_limit;
  document.querySelector("#action_type").value = "update";

  if (modal == null) return
  modal.classList.add('active')
  overlay.classList.add('active')
}

// function that will close the modal
function closeModal(modal) {
  if (modal == null) return
  modal.classList.remove('active')
  overlay.classList.remove('active')
}