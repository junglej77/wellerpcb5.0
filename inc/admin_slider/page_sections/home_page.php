<?php
// 回调函数
function home_page()
{
    wp_enqueue_media();

?>

<div id="app">
    <el-table ref="table"
              :data="tableData"
              row-key="id"
              @sort-change="sort_change"
              :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
              :highlight-current-row="true"
              :key="tableKey"
              stripe>
        <el-table-column v-for="(item, key) in columns"
                         :key="key"
                         :prop="key"
                         :class-name="key"
                         v-bind="item">
            <template #header>
                <div class="title_intro">
                    <el-tooltip v-if="columns[key].headerIntro"
                                class="box-item"
                                effect="dark"
                                :content="columns[key].headerIntro"
                                placement="top-start">
                        <span>
                            {{ columns[key].label }}
                            <svg viewBox="0 0 1024 1024"
                                 xmlns="http://www.w3.org/2000/svg"
                                 data-v-ea893728="">
                                <path fill="currentColor"
                                      d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm0 192a58.432 58.432 0 0 0-58.24 63.744l23.36 256.384a35.072 35.072 0 0 0 69.76 0l23.296-256.384A58.432 58.432 0 0 0 512 256zm0 512a51.2 51.2 0 1 0 0-102.4 51.2 51.2 0 0 0 0 102.4z">
                                </path>
                            </svg>
                        </span>
                    </el-tooltip>
                    <span v-else>{{ columns[key].label }}</span>
                    <span v-if="columns[key].sortable"
                          class="caret-wrapper">
                        <i class="sort-caret ascending"></i>
                        <i class="sort-caret descending"></i>
                    </span>
                </div>
                <div class="title_filter"
                     v-if="columns[key].queryForm"
                     @click.stop>
                    <!-- 搜索页面板块 -->
                    <el-input v-if="key == 'alias'"
                              v-model.trim="queryForm.data.alias"
                              placeholder="搜索板块"
                              @change="getTableList"
                              clearable></el-input>
                </div>
                <div class="operation"
                     v-if="key == 'oerationSelf'">
                    <el-button v-if="userInfo.id == 1"
                               type="primary"
                               @click="handleAddPop({})">新增栏目</el-button>
                </div>
            </template>
            <template v-if="key == 'imgUrl'"
                      #default="scope">

                <el-image style="width: 60px; height: 60px"
                          v-if="scope.row[key]"
                          preview-teleported
                          :preview-src-list="[scope.row[key]]"
                          :src="scope.row[key]">
                </el-image>
                <div v-else-if="scope.row.icon"
                     class="icon_wrap"
                     v-html="scope.row.icon">
                </div>
            </template>
            <template v-if="key == 'oerationSelf'"
                      #default="scope">
                <el-button type="primary"
                           text
                           @click="handleAddPop(scope.row)">新增</el-button>
                <el-button type="warning"
                           text
                           @click="handleEditPop(scope.row)">编辑</el-button>
                <el-button v-if="userInfo.id == 1 && scope.row.parentId == null"
                           type="danger"
                           text
                           @click="handleRemoveRow(scope.row)">删除</el-button>
                <el-button v-else-if="scope.row.parentId != null"
                           type="danger"
                           text
                           @click="handleRemoveRow(scope.row)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>

    <el-dialog v-model="dialogFormVisible"
               @closed="handleDialogClose">
        <div slot="header"
             class="dialog-header">
            <h1>
                {{isEidt?'修改':'新增'}}栏目
            </h1>
            <p v-if="rowParents.length != 0">
                <span v-for="(item,index) in rowParents">
                    {{ item.sectionType }}
                </span>
            </p>
        </div>
        <el-form ref="Form"
                 :model="form">
            <el-form-item label="板块"
                          :label-width="formLabelWidth">
                <el-input v-model="form.sectionType"
                          :disabled="isEidt"
                          autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="别名"
                          :label-width="formLabelWidth">
                <el-input v-model="form.alias"
                          autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="导向链接"
                          :label-width="formLabelWidth">
                <el-input v-model="form.linkTo"
                          autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="标题"
                          :label-width="formLabelWidth">
                <el-input v-model="form.title"
                          autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="描述"
                          :label-width="formLabelWidth">
                <el-input v-model="form.description"
                          type="textarea"
                          :rows="5"
                          autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="图片"
                          :label-width="formLabelWidth">
                <div class="jungle_upload"
                     :class="form.imgId ? 'hadImg':''">
                    <img :src="form.imgUrl"
                         :alt="form.imgAlt">
                    <div class="icon_wrap">
                        <svg viewBox="0 0 1024 1024"
                             class="upload"
                             @click="selectImage"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                  d="M480 480V128a32 32 0 0 1 64 0v352h352a32 32 0 1 1 0 64H544v352a32 32 0 1 1-64 0V544H128a32 32 0 0 1 0-64h352z">
                            </path>
                        </svg>
                        <svg viewBox="0 0 1024 1024"
                             class="enlarge"
                             @click="dialogVisible=true"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                  d="m795.904 750.72 124.992 124.928a32 32 0 0 1-45.248 45.248L750.656 795.904a416 416 0 1 1 45.248-45.248zM480 832a352 352 0 1 0 0-704 352 352 0 0 0 0 704zm-32-384v-96a32 32 0 0 1 64 0v96h96a32 32 0 0 1 0 64h-96v96a32 32 0 0 1-64 0v-96h-96a32 32 0 0 1 0-64h96z">
                            </path>
                        </svg>
                        <svg viewBox="0 0 1024 1024"
                             class="delete"
                             @click="deleteImg"
                             xmlns="http://www.w3.org/2000/svg"
                             data-v-ea893728="">
                            <path fill="currentColor"
                                  d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z">
                            </path>
                        </svg>
                    </div>
                </div>
            </el-form-item>
            <el-form-item label="icon"
                          :label-width="formLabelWidth">
                <el-input v-model="form.icon"
                          autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="数字"
                          :label-width="formLabelWidth">
                <el-input v-model="form.number"
                          autocomplete="off"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer"
             class="dialog-footer">
            <el-button @click="dialogFormVisible = false">取 消</el-button>
            <el-button type="primary"
                       @click="submit">确 定</el-button>
        </div>
    </el-dialog>

    <el-dialog v-model="dialogVisible">
        <img style="width:100%;"
             :src="form.imgUrl"
             alt="">
    </el-dialog>
</div>
<script>
    const app = Vue.createApp({
        data() {
            return {
                userInfo: {},
                queryForm: {
                    order: 'ASC',
                    orderby: "menu_order",
                    data: {},
                },
                columns: {
                    imgUrl: {
                        label: "图片",
                    },
                    alias: {
                        label: "模块",
                    },
                    title: {
                        label: "标题",
                    },
                    description: {
                        label: "描述",
                    },
                    linkTo: {
                        label: "跳转链接",
                    },
                    oerationSelf: {
                        label: "操作",
                        width: 158,
                        fixed: "right",
                    },
                },
                tableData: [],
                dialogFormVisible: false,
                isEidt: false, // 是或否修改栏目？
                rowParents: [], // 编辑的当前元素的父节点
                form: {},
                formLabelWidth: '120px',
                dialogVisible: false,
                uploadedFiles: {}, // 从媒体库选择的图片或者有了的图片
                page: {
                    pages: 15,
                    paged: 1,
                    total: 0,
                    total_pages: 1
                }, // 翻页
                activeRows: new Array(0),
                tableKey: null, // 刷新表格数据
                sortable: null, // sortable对象
            }
        },
        mounted() {
            this.getTableList()
            axios.get('/wp-json/wp/v2/users/me', {
                withCredentials: true,
            }).then((response) => {
                this.userInfo = Object.assign(this.userInfo, response.data)
            }).catch((error) => {
                console.log(error);
            });
            this.rowDrop(); // 拖动表格初始化
        },
        methods: {
            sort_change(column) {
                Object.assign(this.queryForm, {
                    order: column.order == "ascending" ? 'ASC' : 'DESC',
                    orderby: column.prop,
                });
                this.getTableList();
            }, // 排序
            getTableList() {
                axios.get('/wp-json/pageSections/getTreeList', {
                    params: Object.assign({}, this.queryForm,
                        this.page
                    ),
                }).then(response => {
                    this.tableData = response.data.data
                    this.page = response.data.page
                    this.activeRows = this.treeToTile(this.clone(response.data.data))
                }).catch(error => {
                    console.error(error);
                });
            },
            getTableItem(id) {
                axios.get('/wp-json/pageSections/get/', {
                    params: {
                        id: id
                    }
                }).then(response => {
                    console.log(response.data);
                }).catch(error => {
                    console.error(error);
                });
            },
            // 新增栏目/子栏目
            handleAddPop(row) {
                this.isEidt = false;
                if (Object.keys(row).length) {
                    const nodeData = row;
                    this.rowParents = this.findParentNodes(nodeData.id, this.tableData);
                    this.rowParents.push({
                        id: row.id,
                        sectionType: row.sectionType,
                    })
                    Object.assign(this.form, {
                        parentId: row.id,
                        sectionType: 'list',
                    })
                }
                this.showUpload = true
                this.dialogFormVisible = true;
            },
            // 删除当前栏目
            handleRemoveRow(row) {
                this.$messageBox.confirm(
                    '确定删除当前栏目以及其子栏目',
                    '警告', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: '警告',
                }
                )
                    .then(() => {
                        axios.delete('/wp-json/pageSections/delete/' + row.id)
                            .then(response => {
                                this.$message({
                                    type: 'success',
                                    message: response.data.message,
                                    offset: 200
                                })
                                this.getTableList()
                            }).catch(error => {
                                console.error(error);
                            });

                    })
                    .catch(() => {
                        this.$message({
                            type: 'info',
                            message: '取消删除',
                            offset: 200
                        })
                    })

            },
            // 编辑栏目
            handleEditPop(row) {
                this.isEidt = true;
                const nodeData = row;
                this.rowParents = this.findParentNodes(nodeData.id, this.tableData);
                this.form = Object.assign({}, row);
                this.dialogFormVisible = true
            },
            // 循环获取其父元素
            findParentNodes(nodeId, data, parents = []) {
                // 遍历数据源
                for (const node of data) {
                    // 如果当前节点就是目标节点，返回其父节点数组
                    if (node.id === nodeId) {
                        return parents;
                    }

                    // 如果当前节点有子节点，递归遍历子节点
                    if (node.children) {
                        const result = this.findParentNodes(nodeId, node.children, [...parents, node]);
                        // 如果子节点中找到了目标节点，则返回其父节点数组
                        if (result) {
                            return result;
                        }
                    }
                }

                // 如果数据源中未找到目标节点，则返回 null
                return null;
            },
            // 媒体库中选择图片
            selectImage() {
                let custom_uploader = wp.media({
                    title: '上传图片',
                    multiple: false,
                    library: { type: 'image', },
                    button: { text: '确定' }
                })
                custom_uploader.on('select', () => {
                    const selected = custom_uploader.state().get('selection').first().toJSON();
                    // 标记选中的文件为选中状态
                    this.uploadedFiles = selected

                    Object.assign(this.form, {
                        imgId: selected.id,
                        imgUrl: selected.url,
                        imgAlt: selected.alt
                    })
                })
                custom_uploader.open().open();
            },
            // 删除图片
            deleteImg() {
                Object.assign(this.form, {
                    imgId: null,
                    imgUrl: '',
                    imgAlt: ''
                })
            },
            // 上传表单
            async submit() {
                if (this.isEidt) {
                    axios.put('/wp-json/pageSections/update/' + this.form.id, this.form)
                        .then(response => {
                            this.dialogFormVisible = false
                        }).catch(error => {
                            console.error(error);
                        });
                } else {
                    axios.post('/wp-json/pageSections/create', this.form)
                        .then(response => {
                            this.dialogFormVisible = false
                        }).catch(error => {
                            console.error(error);
                        });
                }
            },
            // 关闭编辑界面时候
            handleDialogClose() {
                this.getTableList()
                this.rowParents = []
                this.uploadedFiles = []
                this.form = {}
            },
            initData() {
                if (this.sortable && this.sortable.el) {
                    this.sortable.destroy()
                }
                this.$nextTick(() => {
                    this.setSort()
                })
            },
            // 行拖拽 排序
            rowDrop() {
                // 获取表格节点
                if (this.sortable && this.sortable.el) {
                    this.sortable.destroy()
                }
                this.$nextTick(() => {
                    const el = this.$refs.table.$el.querySelector('.el-table__body-wrapper tbody')
                    if (!el) { return }
                    const _this = this
                    // 插件调用函数
                    Sortable.create(el, {
                        animation: 300,
                        onMove({ dragged, related }) {
                            const oldRow = _this.activeRows[dragged.rowIndex]
                            const newRow = _this.activeRows[related.rowIndex]
                            if (oldRow.level !== newRow.level && oldRow.parentId !== newRow.parentId) { //不能跨级拖拽
                                return false
                            }
                        },
                        onEnd({ oldIndex, newIndex }) {
                            const oldRow = _this.activeRows[oldIndex] // 移动的那个元素
                            const newRow = _this.activeRows[newIndex] // 新的元素
                            if (oldIndex !== newIndex && oldRow.level === newRow.level && oldRow.parentId === newRow.parentId) {
                                const modelProperty = _this.activeRows[oldIndex]
                                const changeIndex = newIndex - oldIndex
                                const index = _this.activeRows.indexOf(modelProperty)
                                if (index < 0) {
                                    return
                                }
                                _this.activeRows.splice(index, 1)
                                _this.activeRows.splice(index + changeIndex, 0, modelProperty)
                                _this.sortMenuData(newRow.parentId, oldRow.children.length) //把排列的数据重新返回给后台
                                _this.$message({
                                    type: 'info',
                                    offset: 300,
                                    duration: 1000,
                                    message: '顺序改变中ing'
                                })
                            }
                        }
                    })
                })
            },
            sortMenuData(parentId, isUpdate) {
                let param = this.activeRows.filter(item => item.parentId === parentId).map((item, index) => {
                    return {
                        id: item.id,
                        menu_order: index
                    }
                })
                axios.put('/wp-json/pageSections/bulkUpdate', param)
                    .then(response => {
                        if (isUpdate) {
                            this.getTableList()
                            this.tableKey = Math.random()  //狠狠的刷新dom
                        }
                        this.$message({
                            type: 'success',
                            offset: 300,
                            duration: 1500,
                            message: '顺序改变成功'
                        })
                        this.rowDrop() // 再把拖拽的功能塞入
                    }).catch(error => {
                        console.error(error);
                    });

            },
            // 将树数据转化为平铺数据
            treeToTile(treeData, childKey = 'children') {
                const arr = []
                const expanded = data => {
                    if (data && data.length > 0) {
                        data.filter(d => d).forEach(e => {
                            arr.push(e)
                            expanded(e[childKey] || [])
                        })
                    }
                }
                expanded(treeData)
                return arr
            },
            // 翻页
            handleSizeChange(val) {
                this.page.pages = val;
                this.getTableList();
            },
            handleCurrentChange(val) {
                this.page.paged = val;
                this.getTableList();
            },
            clone(obj) {
                var o;
                // 如果  他是对象object的话  , 因为null,object,array  也是'object';
                if (typeof obj === 'object') {

                    // 如果  他是空的话
                    if (obj === null) {
                        o = null;
                    }
                    else {

                        // 如果  他是数组arr的话
                        if (obj instanceof Array) {
                            o = [];
                            for (var i = 0, len = obj.length; i < len; i++) {
                                o.push(this.clone(obj[i]));
                            }
                        }
                        // 如果  他是对象object的话
                        else {
                            o = {};
                            for (var j in obj) {
                                o[j] = this.clone(obj[j]);
                            }
                        }

                    }
                } else {
                    o = obj;
                }
                return o;
            }
        }
    });
    app.use(ElementPlus).mount('#app')
</script>

<?php
} ?>