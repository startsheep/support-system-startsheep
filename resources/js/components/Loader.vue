<template>
    <div class="loading-section">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<style>
.loading-section {
    position: absolute;
    transition: all 0.5s ease-in;
    transition-duration: 2s;
    z-index: 99;
    width: 100%;
    height: 100%;
    align-self: center;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(1.5px);
    background-color: rgba(244, 244, 244, 0.15);
    overflow: hidden;
    margin: auto;
}
</style>
