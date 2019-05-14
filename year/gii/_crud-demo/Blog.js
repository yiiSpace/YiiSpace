export class Blog {
  constructor({ id = ``, title = ``, description = `` } = {}) {
    this.id = id
    this.title = title
    this.description = description
  }
}

/**
 * create a Blog model
 * @param data
 * @returns {Readonly<Blog>}
 */
export function createBlog(data) {
  return Object.freeze(new Blog(data))
}
