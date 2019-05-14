import { /* Blog ,*/ createBlog } from './Blog'

const blogData /* BLOGS : Blog[] */ = [
  { id: 11, title: 'Mr. Nice' },
  { id: 12, title: 'Narco' },
  { id: 13, title: 'Bombasto' },
  { id: 14, title: 'Celeritas' },
  { id: 15, title: 'Magneta' },
  { id: 16, title: 'RubberMan' },
  { id: 17, title: 'Dynama' },
  { id: 18, title: 'Dr IQ' },
  { id: 19, title: 'Magma' },
  { id: 20, title: 'Tornado' }
]

function createBlogs() {
  var blogs = []

  blogData.forEach(function(item, idx) {
    blogs.push(createBlog(item))
    console.log(idx)
  })
  return blogs
}
// 单例导出
export const blogs = createBlogs()
