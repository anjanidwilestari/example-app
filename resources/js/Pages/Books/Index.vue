import C:\laragon\www\example-app\resources\js\Components\Tables\TableOne.vue

<template>
  <div>
    <h1 class="text-xl font-semibold mb-4">Daftar Buku</h1>
    <div class="mb-4">
      <!-- Menggunakan Link dari Inertia untuk navigasi -->
      <inertia-link :href="route('books.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Buku</inertia-link>
    </div>
    <TableOne :books="books" />
      <thead>
        <tr>
          <th class="px-4 py-2 border">Judul</th>
          <th class="px-4 py-2 border">Penulis</th>
          <th class="px-4 py-2 border">Deskripsi</th>
          <th class="px-4 py-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop untuk menampilkan buku-buku -->
        <tr v-for="book in books" :key="book.id">
          <td class="px-4 py-2 border">{{ book.title }}</td>
          <td class="px-4 py-2 border">{{ book.author }}</td>
          <td class="px-4 py-2 border">{{ book.description }}</td>
          <td class="px-4 py-2 border">
            <!-- Edit menggunakan Link -->
            <inertia-link :href="route('books.edit', book.id)" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</inertia-link>

            <!-- Tombol untuk menghapus menggunakan Inertia -->
            <button @click="deleteBook(book.id)" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
          </td>
        </tr>
      </tbody>
      <TableOne :books="books" />
    <!-- Menggunakan komponen TableOne -->
    
  </div>
</template>

<script>
import TableOne from '@/Components/Tables/TableOne.vue';
export default {
  props: {
    books: Array,
  },
  components: {
    TableOne, // Menambahkan komponen TableOne agar bisa digunakan di template
  },

  methods: {
    // Fungsi untuk menghapus buku
    deleteBook(bookId) {
      if (confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
        // Menggunakan Inertia untuk menghapus buku secara asinkron
        Inertia.delete(route('books.destroy', bookId));
      }
    },
  },
};
</script>
