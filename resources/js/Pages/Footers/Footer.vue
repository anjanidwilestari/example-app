<template>
    <div>
      <h1>Footer CRUD</h1>
      
      <!-- Formulir untuk Menambahkan Footer -->
      <form @submit.prevent="createFooter">
        <input v-model="newFooterName" type="text" placeholder="Footer Name" required />
        <button type="submit">Add Footer</button>
      </form>
  
      <ul>
        <!-- Menampilkan semua footer -->
        <li v-for="footer in footers" :key="footer.id">
          {{ footer.name }}
          <button @click="openEditModal(footer)">Edit</button>
          <button @click="deleteFooter(footer.id)">Delete</button>
        </li>
      </ul>
  
      <!-- Modal Edit Footer -->
      <div v-if="showEditModal" class="modal">
        <div class="modal-content">
          <h2>Edit Footer</h2>
          <input v-model="editFooterName" type="text" required />
          <button @click="updateFooter">Save Changes</button>
          <button @click="closeEditModal">Cancel</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const footers = ref([]);
  const newFooterName = ref('');
  const showEditModal = ref(false);
  const editFooterId = ref(null);
  const editFooterName = ref('');
  
  // Fungsi untuk mengambil semua footer dari server
  const fetchFooters = async () => {
    const { data } = await axios.get('/footers');
    footers.value = data;
  };
  
  // Fungsi untuk menambahkan footer baru
  const createFooter = async () => {
    await axios.post('/footers', { name: newFooterName.value });
    newFooterName.value = '';
    fetchFooters();
  };
  
  // Fungsi untuk membuka modal edit
  const openEditModal = (footer) => {
    editFooterId.value = footer.id;
    editFooterName.value = footer.name;
    showEditModal.value = true;
  };
  
  // Fungsi untuk memperbarui footer
  const updateFooter = async () => {
    await axios.put(`/footers/${editFooterId.value}`, { name: editFooterName.value });
    showEditModal.value = false;
    fetchFooters();
  };
  
  // Fungsi untuk menutup modal edit
  const closeEditModal = () => {
    showEditModal.value = false;
    editFooterName.value = '';
  };
  
  // Fungsi untuk menghapus footer
  const deleteFooter = async (id) => {
    await axios.delete(`/footers/${id}`);
    fetchFooters();
  };
  
  // Memuat daftar footer saat komponen dipasang
  onMounted(fetchFooters);
  </script>
  
  <style scoped>
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  button {
    margin-top: 10px;
  }
  </style>
  