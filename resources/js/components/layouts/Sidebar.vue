<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand text-center">
                <span class="material-symbols-outlined align-middle">
                    support_agent </span
                >&nbsp;
                <span class="align-middle">SSS</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Home' }">
                        <span
                            class="material-symbols-outlined fs-3 align-middle"
                            >home</span
                        >&nbsp;
                        <span class="align-middle">Home</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Ticket' }">
                        <span
                            class="material-symbols-outlined fs-3 align-middle"
                        >
                            confirmation_number </span
                        >&nbsp;
                        <span class="align-middle">Ticket</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Project' }">
                        <span
                            class="material-symbols-outlined fs-3 align-middle"
                        >
                            inventory_2 </span
                        >&nbsp;
                        <span class="align-middle">Project</span>
                    </router-link>
                </li>

                <li class="sidebar-item">
                    <router-link class="sidebar-link" :to="{ name: 'Admin' }">
                        <span
                            class="material-symbols-outlined fs-3 align-middle"
                        >
                            group </span
                        >&nbsp;
                        <span class="align-middle">User</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script></script>
