<template>
    <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
                <li class="nav-item dropdown">
                    <a
                        class="nav-icon dropdown-toggle"
                        href="#"
                        id="messagesDropdown"
                        data-bs-toggle="dropdown"
                    >
                        <div class="position-relative">
                            <i
                                class="align-middle"
                                data-feather="message-square"
                            ></i>
                            <span class="indicator">4</span>
                        </div>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                        aria-labelledby="messagesDropdown"
                    >
                        <div class="dropdown-menu-header">
                            <div class="position-relative">4 New Messages</div>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <div class="row g-0 align-items-center">
                                    <div class="col-2">
                                        <img
                                            src=""
                                            class="avatar img-fluid rounded-circle"
                                            alt="Vanessa Tucker"
                                        />
                                    </div>
                                    <div class="col-10 ps-2">
                                        <div class="text-dark">
                                            Vanessa Tucker
                                        </div>
                                        <div class="text-muted small mt-1">
                                            Nam pretium turpis et arcu. Duis
                                            arcu tortor.
                                        </div>
                                        <div class="text-muted small mt-1">
                                            15m ago
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="row g-0 align-items-center">
                                    <div class="col-2">
                                        <img
                                            src=""
                                            class="avatar img-fluid rounded-circle"
                                            alt="William Harris"
                                        />
                                    </div>
                                    <div class="col-10 ps-2">
                                        <div class="text-dark">
                                            William Harris
                                        </div>
                                        <div class="text-muted small mt-1">
                                            Curabitur ligula sapien euismod
                                            vitae.
                                        </div>
                                        <div class="text-muted small mt-1">
                                            2h ago
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="row g-0 align-items-center">
                                    <div class="col-2">
                                        <img
                                            src=""
                                            class="avatar img-fluid rounded-circle"
                                            alt="Christina Mason"
                                        />
                                    </div>
                                    <div class="col-10 ps-2">
                                        <div class="text-dark">
                                            Christina Mason
                                        </div>
                                        <div class="text-muted small mt-1">
                                            Pellentesque auctor neque nec urna.
                                        </div>
                                        <div class="text-muted small mt-1">
                                            4h ago
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="list-group-item">
                                <div class="row g-0 align-items-center">
                                    <div class="col-2">
                                        <img
                                            src=""
                                            class="avatar img-fluid rounded-circle"
                                            alt="Sharon Lessman"
                                        />
                                    </div>
                                    <div class="col-10 ps-2">
                                        <div class="text-dark">
                                            Sharon Lessman
                                        </div>
                                        <div class="text-muted small mt-1">
                                            Aenean tellus metus, bibendum sed,
                                            posuere ac, mattis non.
                                        </div>
                                        <div class="text-muted small mt-1">
                                            5h ago
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-menu-footer">
                            <a href="#" class="text-muted">Show all messages</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-icon dropdown-toggle d-inline-block d-sm-none"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <i class="align-middle" data-feather="settings"></i>
                    </a>

                    <a
                        class="nav-link dropdown-toggle d-none d-sm-inline-block"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <span class="text-dark">{{ user.name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <button class="dropdown-item" @click="handleLogout">
                            Log out
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import Cookies from "js-cookie";

export default {
    props: ["user"],
    methods: {
        handleLogout() {
            this.$store
                .dispatch("postData", ["auth/logout", {}])
                .then((result) => {
                    Cookies.remove("token");
                    window.location.replace("/auth/login");
                });
        },
    },
};
</script>
