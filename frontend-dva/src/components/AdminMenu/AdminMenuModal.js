
import React, { Component } from 'react';
import { Modal, Form, Input } from 'antd';

const FormItem = Form.Item;

class AdminMenuEditModal extends Component {

    constructor(props) {
        super(props);
        this.state = {
            visible: false,
        };
    }

    showModelHandler = (e) => {
    if (e) e.stopPropagation();
    this.setState({
                      visible: true,
                  });
};

hideModelHandler = () => {
    this.setState({
        visible: false,
    });
};

okHandler = () => {
    const { onOk } = this.props;
    this.props.form.validateFields((err, values) => {
        if (!err) {
        onOk(values);
        this.hideModelHandler();
    }
});
};

render() {
    const { children } = this.props;
    const { getFieldDecorator } = this.props.form;
    const { id, root, lft, rgt, level, label, url, params, ajaxoptions, htmloptions, is_visible, uid, group_code } = this.props.record;
    const formItemLayout = {
        labelCol: { span: 6 },
        wrapperCol: { span: 14 },
    };

    return (
        <span>
            <span onClick={this.showModelHandler}>
                { children }
            </span>
            <Modal
                title="Edit Admin Menu"
                visible={this.state.visible}
                onOk={this.okHandler}
                onCancel={this.hideModelHandler}
            >
                <Form horizontal onSubmit={this.okHandler}>

                                        <FormItem
                        {...formItemLayout}
                        label="ID"
                    >
                        {
                            getFieldDecorator('id', {
                                initialValue: id,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Root"
                    >
                        {
                            getFieldDecorator('root', {
                                initialValue: root,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Lft"
                    >
                        {
                            getFieldDecorator('lft', {
                                initialValue: lft,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Rgt"
                    >
                        {
                            getFieldDecorator('rgt', {
                                initialValue: rgt,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Level"
                    >
                        {
                            getFieldDecorator('level', {
                                initialValue: level,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Label"
                    >
                        {
                            getFieldDecorator('label', {
                                initialValue: label,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Url"
                    >
                        {
                            getFieldDecorator('url', {
                                initialValue: url,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Params"
                    >
                        {
                            getFieldDecorator('params', {
                                initialValue: params,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Ajaxoptions"
                    >
                        {
                            getFieldDecorator('ajaxoptions', {
                                initialValue: ajaxoptions,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Htmloptions"
                    >
                        {
                            getFieldDecorator('htmloptions', {
                                initialValue: htmloptions,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Is Visible"
                    >
                        {
                            getFieldDecorator('is_visible', {
                                initialValue: is_visible,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Uid"
                    >
                        {
                            getFieldDecorator('uid', {
                                initialValue: uid,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Group Code"
                    >
                        {
                            getFieldDecorator('group_code', {
                                initialValue: group_code,
                            })(<Input />)
                        }
                    </FormItem>
                    
                </Form>
            </Modal>
        </span>
    );
}
}

export default Form.create()(AdminMenuEditModal);
