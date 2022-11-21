<script>
import Pagination from "./Pagination.vue";

export default {
    props: {
        isSort: {
            type: Boolean,
            default: true,
        },
        isShow: {
            type: Boolean,
            default: true,
        },
        isSearch: {
            type: Boolean,
            default: true,
        },
        isPaginate: {
            type: Boolean,
            default: true,
        },
        isDetail: {
            type: Boolean,
            default: true,
        },
        isEdit: {
            type: Boolean,
            default: true,
        },
        isDelete: {
            type: Boolean,
            default: true,
        },
        numeric: {
            type: Boolean,
            default: true,
        },
        headings: {
            type: Array,
            default: []
        },
        data: {
            type: Object,
            default: {}
        },
        variables: {
            type: Array,
            default: []
        },
        metaPagination: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            sort: 10,
            search: ''
        }
    },
    methods: {
        iteration(index) {
            return (
                (this.metaPagination.currentPage - 1) * this.metaPagination.perPage +
                index +
                1
            );
        },
        onSort() {
            this.$emit('onSort', this.sort)
        },
        onSearch() {
            this.$emit('onSearch', this.search)
        },
        onPageChange(e){
            this.$emit('onPageChange', e);
        }
    },
    components: { Pagination },
};
</script>
<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex align-items-center" v-if="isSort">
                Show
                <select class="form-control" @change="onSort" v-model="sort">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entries
            </div>
            <div class="d-flex align-items-center" v-if="isSearch">
                Search: <input type="search" class="form-control" @keyup="onSearch" v-model="search" />
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th v-if="numeric">No</th>
                            <th v-for="(heading, index) in headings" :key="index">{{ heading }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in data" :key="index">
                            <td v-if="numeric">{{ iteration(index) }}</td>
                            <td v-for="variable in variables">{{ item[variable] }}</td>
                            <td>
                                <router-link v-if="isDetail" :to="`/ticket/${item['id']}/detail`" class="btn btn-sm me-2 btn-info text-white"><i class="fa-solid fa-eye"></i></router-link>
                                <router-link v-if="isEdit" :to="`/ticket/${item['id']}/edit`" class="btn btn-sm me-2 btn-warning text-white"><i class="fa-solid fa-edit"></i></router-link>
                                <router-link v-if="isDelete" :to="`/ticket/${item['id']}/delete`" class="btn btn-sm me-2 btn-danger text-white"><i class="fa-solid fa-trash"></i></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <p v-if="isShow">Showing {{ metaPagination.from }} to {{ metaPagination.to }} of {{ metaPagination.total }} entries</p>
            <Pagination v-if="isPaginate" :pagination="metaPagination" @onPageChange="onPageChange($event)" />
        </div>
    </div>
</template>
