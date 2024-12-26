<template>
  <div>
    <h2>Manage Footers</h2>
    
    <!-- Tombol untuk menambah Footer -->
    <button @click="showCreateFooterModal = true">Add Footer</button>

    <!-- Modal untuk menambah Footer -->
    <div v-if="showCreateFooterModal" class="modal">
      <input v-model="newFooterName" placeholder="Footer Name">
      <button @click="createFooter">Create Footer</button>
      <button @click="showCreateFooterModal = false">Cancel</button>
    </div>

    <!-- Tabel Daftar Footers -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
      <thead>
        <tr>
          <th>Footer Name</th>
          <th>Actions</th>
          <th>Sub Footers</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="footer in footers" :key="footer.id">
          <td>{{ footer.name }}</td>
          <td>
            <button @click="editFooter(footer)">Edit</button>
            <button @click="deleteFooter(footer.id)">Delete</button>
          </td>
          <td>
            <!-- Tabel Sub Footers -->
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px;">
              <thead>
                <tr>
                  <th>Sub Footer Name</th>
                  <th>Link</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="subFooter in footer.sub_footers" :key="subFooter.id">
                  <td>{{ subFooter.name }}</td>
                  <td><a :href="subFooter.link" target="_blank">Link</a></td>
                  <td>
                    <button @click="editSubFooter(subFooter)">Edit</button>
                    <button @click="deleteSubFooter(subFooter.id)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
            
            <!-- Tombol untuk menambah Sub Footer -->
            <button @click="addSubFooter(footer.id)" style="margin-top: 10px;">Add Sub Footer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    footers: Array
  },
  data() {
    return {
      showCreateFooterModal: false,
      newFooterName: '',
      newSubFooterName: '',
      newSubFooterLink: ''
    };
  },
  methods: {
    createFooter() {
      this.$inertia.post('/footers', { name: this.newFooterName });
      this.showCreateFooterModal = false;
      this.newFooterName = '';
    },
    deleteFooter(id) {
      this.$inertia.delete(`/footers/${id}`);
    },
    editFooter(footer) {
      const newName = prompt('Edit Footer Name:', footer.name);
      if (newName) {
        this.$inertia.put(`/footers/${footer.id}`, { name: newName });
      }
    },
    addSubFooter(footerId) {
      const name = prompt('Enter Sub Footer Name:');
      const link = prompt('Enter Link:');
      this.$inertia.post(`/footers/${footerId}/sub-footers`, { name, link });
    },
    editSubFooter(subFooter) {
      const newName = prompt('Edit Sub Footer Name:', subFooter.name);
      const newLink = prompt('Edit Sub Footer Link:', subFooter.link);
      if (newName && newLink) {
        this.$inertia.put(`/sub-footers/${subFooter.id}`, { name: newName, link: newLink });
      }
    },
    deleteSubFooter(id) {
      if (confirm("Are you sure you want to delete this subfooter?")) {
        this.$inertia.delete(`/sub-footers/${id}`);
      }
    }
  }
};
</script>

<style scoped>
.modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 20px;
  border: 1px solid #ccc;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}
</style>
