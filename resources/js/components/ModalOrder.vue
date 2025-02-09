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

import { ref, onMounted } from "vue";

const props = defineProps<
    { addresses: { id: number; name: string }[]
    }>();

const form = ref({
  device_id: "",
  address_id: "",
  delivery_time: "",
});

const devices = ref<{ id: number; name: string }[]>([]);
const addresses = ref<{ id: number; name: string }[]>([]);

const getDevices = async () => {
  const response = await fetch("/api/devices");
  devices.value = await response.json();
};

onMounted(async () => {
  await getDevices();
});

const submitOrder = async () => {
  try {
    const response = await fetch("/api/orders", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(form.value),
    });

    if (!response.ok) throw new Error("Ошибка при создании заказа");

    alert("Заказ успешно создан!");
  } catch (error) {
    console.error(error);
    alert("Ошибка отправки заказа");
  }
};
</script>

<template>
  <div class="container">
    <!-- Кнопка для открытия модального окна -->
    <button @click="openModal" class="btn btn-primary">Создать заказ</button>

    <!-- Модальное окно -->
    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal">
        <div class="order-form">
          <h2>Создать заказ</h2>
          <form @submit.prevent="submitOrder">

            <div class="form-group">
              <label for="device">Устройство</label>
              <select id="device" v-model="form.device_id" required>
                <option v-for="device in devices" :key="device.id" :value="device.id">
                  {{ device.name }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label for="address">Адрес</label>
              <select id="address" v-model="form.address_id" required>
                <option v-for="address in props.addresses" :key="address.id" :value="address.id">
                  {{ address.name }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label for="delivery_time">Время доставки</label>
              <input type="datetime-local" id="delivery_time" v-model="form.delivery_time" required />
            </div>

            <button type="submit">Отправить заказ</button>
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


.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input, select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
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
