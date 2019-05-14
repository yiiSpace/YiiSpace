<template>
  <div class="item-manager">

  <el-collapse >
      <el-collapse-item title="高级搜索" name="adv_search">
        <div style="width: 40%">
          <!--高级搜索-->
          <el-form ref="advSearchForm" :model="advSearchForm" label-width="80px" size="mini">

            <el-form-item label="标题" prop="name" size="mini">
              <el-input v-model="advSearchForm.name"></el-input>
            </el-form-item>

            <el-form-item size="mini">
              <el-button size="mini" round type="primary" @click="handleAdvSearch()">搜索</el-button>
              <el-button size="mini" round @click="resetForm('advSearchForm')" >重置</el-button>
            </el-form-item>

          </el-form>
        </div>
      </el-collapse-item>

      <el-collapse-item title="过滤" name="simple_search">
        <!--简单过滤-->
        <el-form :inline="true" ref="simpleSearchForm" :model="simpleSearchForm" class="demo-form-inline" size="mini">
          <el-form-item label="审批人" prop="user">
            <el-input v-model="simpleSearchForm.user" placeholder="审批人"></el-input>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" round @click="handleSimpleSearch()">查询</el-button>
            <el-button size="mini" round @click="resetForm('simpleSearchForm')" >重置</el-button>
          </el-form-item>
        </el-form>

      </el-collapse-item>
    </el-collapse>

    <!--数据列表-->
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span> 数据列表 </span>

        <span style="float:right;">
                <el-button  @click="handleCreate" style="color:blue">添加</el-button>
                <el-button  @click="handleBatchEdit" style="color:blue">批量修改</el-button>
                <el-button  @click="handleBatchDelete" style="color:blue">批量删除</el-button>
        </span>

      </div>

      <el-table
        border
        :data="tableData"
        style="width: 100%"
        @selection-change="handleSelectionChange"
        @sort-change=handleSortChange>

        <el-table-column
          type="selection"
          prop="id"
          width="55">
        </el-table-column>



        <el-table-column
          prop="id"
          sortable
          label="#"
          width="180">
        </el-table-column>

        <el-table-column
          prop="title"
          sortable
          label="姓名"
           >
        </el-table-column>

        <el-table-column
          prop="description"
          label="描述"
          >
        </el-table-column>

        <!--op actions -->
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="handleView(scope.$index, scope.row)">详情</el-button>

            <el-button
              size="mini"
              @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
            <el-button
              size="mini"
              type="danger"
              @click="handleDelete(scope.$index, scope.row)">删除</el-button>
          </template>
        </el-table-column>

      </el-table>

      <!--分页-->
      <div class=" pagination-container" align="right" style="margin: 8px;">
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page="currentPage"
          :page-sizes="[5, 10, 20, 30, 40]"
          :page-size="pageSize"
          layout="total, sizes, prev, pager, next, jumper"
          :total="totalCount">
        </el-pagination>
      </div>
    </el-card>

    <!--删除确认对话框-->

    <!--公用对话框-->
    <el-dialog :title="dialogTitle" :visible.sync="dialogVisible">
      <!--TODO 表单隔离到其他组件去 如果使用组件 可以考虑使用：<component v-bind:is="currentTabForm"></component> -->

      <template v-if="dialogType === 'batchEdit'">

        <el-form :model="batchEditFormModel">

          <el-form-item label="标题" label-width="120px">
            <el-input v-model="batchEditFormModel.title" auto-complete="off"></el-input>
          </el-form-item>

          <el-form-item label="描述" label-width="120px">
            <el-input v-model="batchEditFormModel.description" auto-complete="off"></el-input>
          </el-form-item>
        </el-form>

        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="dialogVisible = false ; doBatchEdit()">确 定2</el-button>
        </div>

      </template>
      <template v-else-if="dialogType === 'view'">
          <el-table
            :data="dataForView"
            highlight-current-row="true"
            style="width: 100%">

            <el-table-column
              prop="id"
              label="#"
              width="180">
            </el-table-column>

            <el-table-column
              prop="title"
              label="标题"
              width="180">
            </el-table-column>

            <el-table-column
              prop="description"
              label="描述">
            </el-table-column>

          </el-table>
      </template>
      <template v-else-if="dialogType === 'C'">
        C
      </template>
      <template v-else>
         <!--新增&&修改-->
        <el-form :model="formModel">

          <el-input type="hidden" v-model="formModel.id" auto-complete="off"></el-input>

          <el-form-item label="标题" label-width="120px">
            <el-input v-model="formModel.title" auto-complete="off"></el-input>
          </el-form-item>

          <el-form-item label="描述" label-width="120px">
            <el-input v-model="formModel.description" auto-complete="off"></el-input>
          </el-form-item>
        </el-form>

        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="dialogVisible = false; handleSave()">确 定</el-button>
        </div>

      </template>

    </el-dialog>

  </div>
</template>

<script>
  import blogService from '../BlogService'

  const advSearchForm = {
    name: '',
    region: ''
  }

  const simpleSearchForm = {
    user: '',
    region: ''
  }

  const formModel = {
    id: 0,
    title: '',
    description: ''
  }

  const emptyFormModel = {
    title: '',
    description: ''
  }

  const batchEditFormModel = {
    ids: [],
    title: '',
    description: ''
  }

  export default {
    data() {
      return {
        loading: false,
        // 搜索
        advSearchForm,
        simpleSearchForm,
        tableData: [],
        dataForView: [],
        // 多选数组
        multipleSelection: [],
        formModel,
        // ## 表单对话框
        // 根据对话框类型 条件式决定显示哪个表单
        dialogType: '',
        dialogTitle: '',
        // dialogVisible: false
        dialogVisible: false,
        batchEditFormModel, // 批量修改
        // ## 分页
        // 默认每页数据量
        pageSize: 10,
        // 默认高亮行数据id
        highlightId: -1,
        // 当前页码
        currentPage: 1,
        // 查询的页码
        start: 1,
        // 默认数据总数
        totalCount: 1000
      }
    },
    created() {
      // NOTE 创造非响应式的属性
      this.searchData = {}
      // alert('created')
      this.getList()
    },
    methods: {
      // search 表单
      handleAdvSearch() {
        const searchData = JSON.parse(JSON.stringify(this.advSearchForm))
        // console.log(searchData)
        this.searchData = searchData

        this.currentPage = 1
        searchData['page'] = 1
        searchData['pageSize'] = this.pageSize
        this.getList(searchData)
      },
      handleSimpleSearch() {
        const searchData = JSON.parse(JSON.stringify(this.simpleSearchForm))
        // console.log(searchData)
        this.searchData = searchData

        this.currentPage = 1
        searchData['page'] = 1
        searchData['pageSize'] = this.pageSize
        this.getList(searchData)
      },
      resetForm(formName) {
        // NOTE: 要设置el-form-item 的prop 属性
        this.$refs[formName].resetFields()
      },
      // 排序 { column, prop, order }
      handleSortChange(column) {
        console.log(column)
      },
      getList(queryObj) {
        const vm = this
        blogService.query(queryObj).then(function(data) {
          vm.tableData = data
          console.log(vm.tableData)
        }, function(data) {
          alert('error')
        })
      },
      handleCreate() {
        const vm = this
        // console.log(index, row)
        // 创建和修改共用同一模型 区别的地方在是否有隐藏id的赋值 TODO 可以清空下表单resetForm('createOrUpdateForm')
        vm.formModel = emptyFormModel
        vm.dialogTitle = '添加'
        vm.dialogType = 'create'
        vm.dialogVisible = true
        // vm.formModel = data
      },
      // table row op actions
      handleEdit(index, row) {
        const vm = this
        // console.log(index, row)
        const id = row.id
        blogService.getOne(id).then(function(data) {
          console.log(data)
          vm.dialogType = 'edit'
          vm.dialogTitle = '编辑'
          vm.dialogVisible = true
          vm.formModel = data
          //
        }, function(error) {
          console.log(error)
        })
      },
      handleSave() {
        const vm = this
        const model = vm.formModel
        const id = model.id
        if (id) {
          //  edit action
          // delete model.id
          blogService.update(id, model).then(function(data) {
            //  此处操作成功后 应该刷新数据列表
            vm.getList()
          }, function(error) {
            console.log(error)
          })
        } else {
          // create action
          blogService.create(model).then(function(data) {
            console.log(data)
            //  创建成功后 应该刷新数据列表
            vm.getList()
          }, function(error) {
            console.log(error)
          })
        }
      },
      handleDelete(index, row) {
        // this.dialogVisible = true
        if (confirm('确定删除此项?')) {
          const vm = this
          //  do delete
          console.log(row)
          const id = row.id
          blogService.remove(id).then(function(data) {
            console.log(data)
            //  此处删除成功后 应该刷新数据列表
            vm.getList()
          }, function(error) {
            console.log(error)
          })
        }
      },
      handleView(index, row) {
        const vm = this
        const id = row.id
        blogService.getOne(id).then(function(data) {
          console.log(data)
          vm.dialogType = 'view'
          vm.dialogTitle = '详情'
          vm.dialogVisible = true
          //
          vm.dataForView = [data]
        }, function(error) {
          console.log(error)
        })
      },
      // 批处理
      // 多选响应
      handleSelectionChange: function(val) {
        this.multipleSelection = val
      },
      handleBatchDelete() {
        if (this.multipleSelection.length === 0) {
          alert('请至少选择一项！')
          return
        }
        if (!confirm('确定删除选中项?')) {
          return
        }
        const vm = this
        // 收集主键集合
        const ids = []
        this.multipleSelection.forEach((item) => {
          ids.push(item.id)
        })
        blogService.batchDelete(ids).then(function(data) {
          // console.log(data)
          //  此处删除成功后 应该刷新数据列表
          vm.getList() // this.loadData(this.criteria, this.currentPage, this.pageSize);
        }, function(error) {
          console.log(error)
        })
      },
      handleBatchEdit() {
        if (this.multipleSelection.length === 0) {
          alert('请至少选择一项！')
          return
        }
        if (!confirm('确定修改选中项?')) {
          return
        }
        const vm = this
        // 收集主键集合
        const ids = []
        this.multipleSelection.forEach((item) => {
          ids.push(item.id)
        })
        // 设置表单数据
        vm.batchEditFormModel.ids = ids
        vm.dialogType = 'batchEdit'
        vm.dialogTitle = '批量修改'
        vm.dialogVisible = true
        //
      },
      doBatchEdit() {
        const vm = this
        // 设置表单数据
        const formData = JSON.parse(JSON.stringify(this.batchEditFormModel))
        // console.log(formData)
        blogService.batchEdit(formData).then(function(data) {
          // console.log(data)
          //  批修改成功后 刷新数据列表
          vm.getList()
        }, function(error) {
          console.log(error)
        })
      },
      // ## 分页
      // 每页显示数据量变更
      handleSizeChange: function(val) {
        this.pageSize = val
        const criteria = this.searchData
        criteria['page'] = this.currentPage
        criteria['pageSize'] = this.pageSize
        // console.log(criteria)
        this.getList(criteria)
      },
      // 页码变更
      handleCurrentChange: function(val) {
        this.currentPage = val
        const criteria = this.searchData
        criteria['page'] = this.currentPage
        criteria['pageSize'] = this.pageSize
        // console.log(criteria)
        this.getList(criteria)
      }
    }
  }

</script>

<style lang="scss" type="text/scss" rel="stylesheet/scss" scoped>
  .item-manager {
    margin: 5px
  }
</style>
