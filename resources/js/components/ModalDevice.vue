<script setup lang="ts">
import { ref } from 'vue';
import CustomerForm from "./Customer.vue";

// Состояние для отображения модального окна
const isModalOpen = ref(false);

// Функция для открытия модального окна
const openModal = () => {
  isModalOpen.value = true;
};

// Функция для закрытия модального окна
const closeModal = () => {
  isModalOpen.value = false;
};

import { ref } from "vue";

const form = ref({
  name: "",
  slug: "",
  description: "",
});

const submitForm = () => {
  console.log("Отправка формы:", form.value);

  fetch("api/devices", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(form.value),
  })
      .then((response) => response.json())
      .then((data) => {
        alert("Устройство успешно создано");
        console.log("Ответ сервера:", data)
      })
      .catch((error) => console.error("Ошибка:", error));
};
</script>

<template>
  <div class="container">
    <!-- Кнопка для открытия модального окна -->
    <button @click="openModal" class="btn btn-primary">Создать девайс</button>

    <!-- Модальное окно -->
    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal">
        <div class="form-container">
          <h2 class="form-title">Создать устройство</h2>
          <form @submit.prevent="submitForm" class="form">
            <div class="form-group">
              <label for="name" class="form-label">Название</label>
              <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="form-input"
                  placeholder="Введите название устройства"
              />
            </div>

            <div class="form-group">
              <label for="slug" class="form-label">Slug</label>
              <input
                  id="slug"
                  v-model="form.slug"
                  type="text"
                  class="form-input"
                  placeholder="Введите slug"
              />
            </div>

            <div class="form-group">
              <label for="description" class="form-label">Описание</label>
              <textarea
                  id="description"
                  v-model="form.description"
                  class="form-input"
                  placeholder="Введите описание устройства"
              ></textarea>
            </div>

            <button type="submit" class="submit-button">Создать</button>
          </form>
        </div>
        <button @click="closeModal" class="btn btn-secondary">Закрыть</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 80%;
  margin: 0 auto;
  padding: 20px;
}

.btn {
  padding: 10px 20px;
  cursor: pointer;
  border: none;
  border-radius: 5px;
  color: white;
  font-size: 16px;
}

.btn-secondary {
  background-color: #6c757d;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal {
  display: flex;
  flex-direction: column;
  max-width: 60%;
  gap: 2rem;
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 16px;
}

.form-label {
  display: block;
  font-size: 1rem;
  margin-bottom: 8px;
  color: #333;
}

.form-input {
  width: 100%;
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.form-input:focus {
  border-color: #4c8bf5;
  outline: none;
  box-shadow: 0 0 5px rgba(76, 139, 245, 0.3);
}

.submit-button {
  width: 100%;
  padding: 12px;
  background-color: #4c8bf5;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #3578e5;
}


button {
  width: 100%;
  padding: 10px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}

</style>
