const config = require('../config.js')

const baseUrl = config.api_base_url

const superagent = require('superagent')
const {expect} = require('chai')  // 不咋有用
const assert = require('power-assert');

const db = require('./fixtures/User');

// ## api url
const apiUrl = `${baseUrl}/quick/test`

before((done) => {
    // app.listen(port, done)
    done()
})

describe('express rest api server', () => {
    let id

    const objData = db.createData

    it('posts an object', (done) => {
        superagent.post(`${baseUrl}/quick/test`)
            .send(objData)
            .end((e, res) => {
                // console.log(res.body)
                const {success, data} = res.body
                //    // expect(e).to.eql(null)
                //   // expect(res.body.length).to.eql(1)
                //  //  expect(res.body[0]._id.length).to.eql(24)
                // //   id = res.body[0]._id
                //   console.log(apiResult.data.email , objData.email)
                //  //   assert(apiResult.data.email == objData.email);
                assert(success == true);
                id = data.id

                done()
            })
    })


    it('retrieves an object', (done) => {
        superagent.get(`${apiUrl}?id=${id}`)
            .end((e, res) => {
                // console.log(res.body)
                // expect(e).to.eql(null)
                // expect(typeof res.body).to.eql('object')
                // expect(res.body._id.length).to.eql(24)
                // expect(res.body._id).to.eql(id)
                // expect(res.body.name).to.eql('John')
                const {success, data} = res.body
                assert(success === true)
                assert(id === data.id)
                done()
            })
    })

    it('retrieves a list', (done) => {
        superagent.get(`${apiUrl}`)
            .end((e, res) => {
                /*
                // console.log(res.body)
                expect(e).to.eql(null)
                expect(res.body.length).to.be.above(0)
                expect(res.body.map((item) => {return item._id})).to.contain(id)
                */
                const {success, data} = res.body
                assert(success === true)
                assert(data.length >= 1)
                done()
            })
    })

    it('updates an object', (done) => {
        superagent.put(`${apiUrl}?id=${id}`)
            .send(db.updateData)
            .end((e, res) => {
                // console.log(res.body, e)
                // expect(e).to.eql(null)
                // expect(typeof res.body).to.eql('object')
                // expect(res.body).to.eql({ msg: 'success' })
                const {success, data} = res.body
                assert(success === true)

                const attrs = Object.keys(db.updateData)
                const attrs2 = Object.keys(data)
                // 求属性的交集
                // a.filter(function(v){ return b.indexOf(v) > -1 })
                const commonAttrs = attrs.filter(v => attrs2.indexOf(v) !== -1)
                commonAttrs.forEach(function (val, idx) {
                    // 注意 伪造数据 跟db 数据有时候存在截断问题！导致二者不相等
                    expect(db.updateData[val]).to.eql(data[val])
                })

                done()
            })
    })

    it('checks an updated object', (done) => {
        superagent.get(`${apiUrl}?id=${id}`)
            .end((e, res) => {
                // console.log(res.body)
                // expect(e).to.eql(null)
                // expect(typeof res.body).to.eql('object')
                // expect(res.body._id.length).to.eql(24)
                // expect(res.body._id).to.eql(id)
                // expect(res.body.name).to.eql('Peter')
                const {success, data} = res.body
                assert(success === true)
                // TODO 同上 检测更新成功
                done()
            })
    })
    // 删除 对方发的是 204 No Content
    it('removes an object', (done) => {
        superagent.del(`${apiUrl}?id=${id}`)
            .end((e, res) => {
                // console.log(res)

                // expect(e).to.eql(null)
                // expect(typeof res.body).to.eql('object')
                // expect(res.body).to.eql({ msg: 'success' })

                assert(res == undefined )
                done()
            })
    })

    it('checks an removed object', (done) => {
        superagent.get(`${apiUrl}?id=${id}`)
            .end((e, res) => {
               // console.log(res.body)
                /*
                expect(e).to.eql(null)
                expect(res.body.map(item=>item._id)).not.to.eql(id)
                */
                const {success, data} = res.body
                assert(success === false)
                done()
            })
    })


})
