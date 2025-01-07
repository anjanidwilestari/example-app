<template>
    <div class="product-detail container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="/">Home</a> &gt; <a href="/products">Product</a> &gt;
            {{ product.name }}
        </nav>

        <!-- Product Info -->
        <div class="product-info">
            <div class="product-images">
                <img
                    :src="product.image"
                    alt="Product Image"
                    class="main-image"
                />
                <div class="thumbnails">
                    <img
                        v-for="image in product.images"
                        :key="image.id"
                        :src="image.url"
                        alt="Thumbnail"
                        class="thumbnail"
                    />
                </div>
            </div>

            <div class="product-details">
                <h1>{{ product.name }}</h1>
                <h2>{{ product.category.name }}</h2>
                <p class="price">Rp {{ product.price.toLocaleString() }}</p>

                <!-- Actions -->
                <div class="actions">
                    <button class="btn buy-now">Buy Now</button>
                    <button class="btn compare">Compare Product</button>
                </div>

                <!-- Options -->
                <div class="options">
                    <label>
                        <input type="checkbox" />
                        + Stand
                    </label>
                    <label>
                        <input type="checkbox" />
                        + UPS
                    </label>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="product-description">
            <h3>Deskripsi Produk</h3>
            <p>{{ product.description }}</p>

            <div class="features">
                <h4>Fitur</h4>
                <ul>
                    <li v-for="feature in product.features" :key="feature.id">
                        {{ feature.feature }} - {{ feature.description }}
                    </li>
                </ul>
            </div>

            <div class="specifications">
                <h4>Spesifikasi</h4>
                <ul>
                    <li
                        v-for="specification in product.specifications"
                        :key="specification.id"
                    >
                        {{ specification.specification }}:
                        {{ specification.description }}
                    </li>
                </ul>
            </div>
        </div>

        <!-- Related Products -->
        <div class="related-products">
            <h3>Produk Terkait</h3>
            <div class="products-grid">
                <div
                    v-for="relatedProduct in relatedProducts"
                    :key="relatedProduct.id"
                    class="product-card"
                >
                    <img
                        :src="relatedProduct.image"
                        alt="Product Image"
                        class="product-image"
                    />
                    <h4>{{ relatedProduct.name }}</h4>
                    <p>{{ relatedProduct.sub_category.name }}</p>
                    <p class="price">
                        Rp {{ relatedProduct.price.toLocaleString() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: Object,
        relatedProducts: Array,
    },
};
</script>

<style scoped>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.product-info {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.product-images {
    flex: 1;
}

.main-image {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.thumbnails {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
}

.product-details {
    flex: 2;
}

.price {
    font-size: 24px;
    color: #333;
    margin-top: 10px;
}

.actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.buy-now {
    background-color: #007bff;
    color: #fff;
}

.compare {
    background-color: #6c757d;
    color: #fff;
}

.options {
    margin-top: 20px;
}

.product-description {
    margin-top: 40px;
}

.features,
.specifications {
    margin-top: 20px;
}

.related-products {
    margin-top: 40px;
}

.products-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.product-card {
    width: calc(33.333% - 20px);
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 10px;
    text-align: center;
}

.product-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
}

.price {
    font-weight: bold;
    margin-top: 10px;
}
</style>
