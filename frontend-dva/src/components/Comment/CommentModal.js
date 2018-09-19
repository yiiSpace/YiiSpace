
import React, { Component } from 'react';
import { Modal, Form, Input } from 'antd';

const FormItem = Form.Item;

class CommentEditModal extends Component {

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
    const { id, user_id, parent_id, model, model_id, model_owner_id, name, url, email, text, model_profile_data, status, create_time, ip, level, root, lft, rgt } = this.props.record;
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
                title="Edit Comment"
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
                        label="User ID"
                    >
                        {
                            getFieldDecorator('user_id', {
                                initialValue: user_id,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Parent ID"
                    >
                        {
                            getFieldDecorator('parent_id', {
                                initialValue: parent_id,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Model"
                    >
                        {
                            getFieldDecorator('model', {
                                initialValue: model,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Model ID"
                    >
                        {
                            getFieldDecorator('model_id', {
                                initialValue: model_id,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Model Owner ID"
                    >
                        {
                            getFieldDecorator('model_owner_id', {
                                initialValue: model_owner_id,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Name"
                    >
                        {
                            getFieldDecorator('name', {
                                initialValue: name,
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
                        label="Email"
                    >
                        {
                            getFieldDecorator('email', {
                                initialValue: email,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Text"
                    >
                        {
                            getFieldDecorator('text', {
                                initialValue: text,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Model Profile Data"
                    >
                        {
                            getFieldDecorator('model_profile_data', {
                                initialValue: model_profile_data,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Status"
                    >
                        {
                            getFieldDecorator('status', {
                                initialValue: status,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Create Time"
                    >
                        {
                            getFieldDecorator('create_time', {
                                initialValue: create_time,
                            })(<Input />)
                        }
                    </FormItem>
                                        <FormItem
                        {...formItemLayout}
                        label="Ip"
                    >
                        {
                            getFieldDecorator('ip', {
                                initialValue: ip,
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
                    
                </Form>
            </Modal>
        </span>
    );
}
}

export default Form.create()(CommentEditModal);
