<template>
    <float-menu
        :position="'top left'"
        :dimension="50"
        :menu-data="items"
        :on-selected="handleSelection"
        :flip-on-edges="true"
        :theme="{
            primary: '#00ff00',
            textColor: '#ff8800',
            menuBgColor: '#00ffff',
            textSelectedColor: '#7300ff'}"
        menu-orientation="bottom"
        :fixed="true"
    >
        Drag
    </float-menu>
    <float-menu
        :position="'top right'"
        :dimension="100"
        :menu-data="items"
        :on-selected="handleSelection"
        :flip-on-edges="false"
        menu-style="accordion"
        menu-orientation="bottom"
    >


    </float-menu>
</template>

<script>
import { FloatMenu } from "vue-float-menu";
import "vue-float-menu/dist/vue-float-menu.css";

export default {
    name: "test",
    components: {
        FloatMenu,
    },
    setup() {
        const handleSelection = (name) => {
            console.log(name);
        };
        console.log(2312)
        return {
            handleSelection,
        };
    },
    data() {
        return {
            items: [
                { name: "New", disabled: "true"},
                {
                    name: "Edit",
                    subMenu: {
                        name: "edit-items",
                        items: [{ name: "Copy" }, { name: "Paste" }],
                    },
                },
                {
                    name: "Open Recent",
                    subMenu: {
                        name: "recent-items",
                        items: [{ name: "Document 1" }, { name: "Document 2" }],
                    },
                },
                {divider: true},
                {
                    name: "Settings",
                    subMenu: {
                        name: "settings",
                        items: [
                            {
                                name: "Themes",
                                subMenu: {
                                    name: "sub-themes",
                                    items: [
                                        { name: "Dark" },
                                        { name: "Light" },
                                        { name: "Blue" },
                                        { name: "Green" },
                                    ],
                                },
                            },
                            { name: "Keymaps" },
                        ],
                    },
                },
                {
                    name: "Save",
                },
                {
                    name: "Save As",
                },
                {divider: true},
                {
                    name: "Close",
                },
                {
                    name: "Exit",
                },
            ],
        };
    },
};
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
