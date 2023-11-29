<template>
    <div>
        <button @click="show">Show Lightbox</button>

        <div v-for="(img, index) in imgsRef" :key="index">
            <button @click="openLightbox(index)">
                <img :src="img" alt="Image" style="max-width: 100%; height: auto; cursor: pointer;">
            </button>
        </div>

        <vue-easy-lightbox :visible="visibleRef" :imgs="imgsRef" :index="indexRef" @hide="onHide" />
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import VueEasyLightbox, { useEasyLightbox } from 'vue-easy-lightbox'

export default defineComponent({
    components: {
        VueEasyLightbox
    },
    setup() {
        const {
            // methods
            show, onHide, changeIndex,
            // refs
            visibleRef, indexRef, imgsRef
        } = useEasyLightbox({
            // src / src[]
            imgs: [
                'http://via.placeholder.com/250x150',
                'http://via.placeholder.com/300x150',
                'http://via.placeholder.com/350x150'
            ],
            // initial index
            initIndex: 0
        })

        const openLightbox = (index) => {
            changeIndex(index);
            show();
        };

        return {
            visibleRef,
            indexRef,
            imgsRef,
            show,
            onHide,
            openLightbox
        }
    }
})
</script>
