import ButtonEditing from './buttonediting';
import { Plugin } from 'ckeditor5/src/core';
import ButtonUI from './buttonui.js';

export default class Button extends Plugin {
  static get requires() {
    return [ ButtonEditing, ButtonUI ];
  }
}
