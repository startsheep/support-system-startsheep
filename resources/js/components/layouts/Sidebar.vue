<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">My Portofolio</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Home' }">
                        <i class="align-middle" data-feather="sliders"></i>
                        <span class="align-middle">Home</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Ticket' }">
                        <i class="align-middle" data-feather="ticket"></i>
                        <span class="align-middle">Ticket</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Project' }">
                        <i class="align-middle" data-feather="package"></i>
                        <span class="align-middle">Project</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Admin' }">
                        <i class="align-middle" data-feather="user"></i>
                        <span class="align-middle">User</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script></script>
