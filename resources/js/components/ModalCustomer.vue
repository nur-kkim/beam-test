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
import { onMounted, reactive, ref } from "vue";
import { data } from "autoprefixer";

interface Address {
  id?: number;
  name?: string;
  apartment?: string;
  street?: string;
  house?: string;
  description?: string;
}

interface CustomerForm {
  id?: string;
  phone_number: string;
  name: string;
  inn?: string;
  addresses: Address[];
}

const form = reactive<CustomerForm>({
  id: "",
  phone_number: "",
  name: "",
  inn: "",
  addresses: [{ id: undefined, name: "", apartment: "", street: "", house: "", description: "" }],
});

const loading = ref(false);
const successMessage = ref<string | null>(null);
const errorMessage = ref<string | null>(null);
const emit = defineEmits(["customerCreated"]);

const addAddress = () => {
  form.addresses.push({ id: undefined, name: "", apartment: "", street: "", house: "", description: "" });
};

const removeAddress = (index: number) => {
  form.addresses.splice(index, 1);
};


const submitForm = async () => {
  loading.value = true;
  successMessage.value = null;
  errorMessage.value = null;

  try {
    if (form.id) {
      const response = await fetch("/api/customers/" + form.id, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(form),
      });
    } else {
      const response = await fetch("/api/customers", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(form),
      });
    }

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || "Ошибка при отправке данных");
    }

    const data = await response.json();
    emit("customerCreated", data);

    successMessage.value = "Клиент успешно добавлен!";
    console.log("Ответ от сервера:", data);

    form.id = data.id
    form.phone_number = "";
    form.name = "";
    form.inn = "";
    form.addresses = [{ id: undefined, name: "", apartment: "", street: "", house: "", description: "" }];
  } catch (error: any) {
    errorMessage.value = error.message;
    console.error("Ошибка:", error);
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  try {
    const response = await fetch("/api/get_currant_customer");
    if (!response.ok) throw new Error("Ошибка загрузки пользователя");

    const user = await response.json();
    emit("customerCreated", user);

    if (user) {
      form.id = user.id
      form.phone_number = user.phone_number;
      form.name = user.name;
      form.inn = user.inn?.inn;
      form.addresses = user.addresses;
    }
  } catch (error) {
    console.error(error);
  }
});

</script>

<template>
  <div class="container">
    <!-- Кнопка для открытия модального окна -->
    <button @click="openModal" class="btn btn-primary">Создать информацию о заказчике</button>

    <!-- Модальное окно -->
    <div v-if="isModalOpen" class="modal-overlay">
      <div class="modal">
        <div class="form-container">
          <h2 class="form-title">Форма заявки</h2>
          <form @submit.prevent="submitForm" class="form">
            <div class="form-group">
              <label for="phone" class="form-label">Телефон</label>
              <input
                  id="phone"
                  v-model="form.phone_number"
                  type="text"
                  class="form-input"
                  placeholder="+996XXXXXXXXX"
              />
            </div>

            <div class="form-group">
              <label for="name" class="form-label">Имя</label>
              <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="form-input"
                  placeholder="Ваше имя"
              />
            </div>

            <div class="form-group">
              <label for="inn" class="form-label">ИНН</label>
              <input
                  id="inn"
                  v-model="form.inn"
                  type="text"
                  class="form-input"
                  placeholder="ИНН (необязательно)"
              />
            </div>

            <label class="form-label">Адреса</label>
            <div class="address-group">
              <div v-for="(address, index) in form.addresses" :key="index" class="address-item">
                <input v-model="address.name" type="text" placeholder="Название" class="form-input" />
                <input v-model="address.street" type="text" placeholder="Улица" class="form-input" />
                <input v-model="address.house" type="text" placeholder="Дом" class="form-input" />
                <input v-model="address.apartment" type="text" placeholder="Квартира" class="form-input" />
                <textarea v-model="address.description" placeholder="Описание" class="form-input"></textarea>
                <button @click.prevent="removeAddress(index)" class="remove-button">Удалить</button>
              </div>
              <button @click.prevent="addAddress" class="add-button">Добавить адрес</button>
            </div>

            <button type="submit" class="submit-button">Отправить</button>
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

.title {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 20px;
}

.btn {
  padding: 10px 20px;
  cursor: pointer;
  border: none;
  border-radius: 5px;
  color: white;
  font-size: 16px;
}

.btn-primary {
  background-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
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

.remove-button {
  color: red;
  font-size: 0.875rem;
  cursor: pointer;
  background: none;
  border: none;
}

.add-button {
  color: #4c8bf5;
  font-size: 0.875rem;
  cursor: pointer;
  background: none;
  border: none;
  margin-top: 8px;
}

.submit-button {
  width: 100%;
  padding: 12px 24px;
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

.address-group {
  margin-bottom: 20px;
  display: flex;
  gap: 0.5rem;
}

.address-item {
  padding: 12px;
  border: 1px solid #eee;
  border-radius: 4px;
  background-color: #fafafa;
  margin-bottom: 12px;
}
</style>
