import plugin from 'tailwindcss/plugin'
import { buttonStyles } from '../config'

/**
 * Add new button styles for better code readability
 */
export const buttons = plugin(function ({ addComponents, theme }) {
  addComponents({
    '.button-info': {
      ...buttonStyles(theme),
      backgroundColor: theme('backgroundColor.cyan.600'),
      color: theme('textColor.white'),
      '&:hover': {
        backgroundColor: theme('backgroundColor.cyan.500'),
        borderColor: theme('borderColor.cyan.500'),
      },
      '&:active': {
        backgroundColor: theme('backgroundColor.cyan.700'),
        borderColor: theme('borderColor.inherit'),
      },
      '&:disabled': {
        cursor: theme('cursor.not-allowed'),
        backgroundColor: theme('backgroundColor.transparent'),
        color: theme('textColor.gray.400'),

        '&:hover': {
          borderColor: theme('borderColor.gray.200')
        }
      },

      '@apply dark:bg-cyan-800 dark:border-cyan-900 dark:active:border-cyan-900': {},
    },

    '.button-info-outlined': {
      ...buttonStyles(theme),

      backgroundColor: theme('backgroundColor.transparent'),
      color: theme('textColor.zinc.600'),
      borderColor: theme('borderColor.cyan.500'),
      '&:hover': {
        backgroundColor: theme('backgroundColor.cyan.600'),
        borderColor: theme('borderColor.cyan.600'),
        color: theme('textColor.zinc.300'),
      },
      '&:active': {
        backgroundColor: theme('backgroundColor.cyan.700'),
        borderColor: theme('borderColor.inherit'),
      },
      '&:disabled': {
        cursor: theme('cursor.not-allowed'),
        backgroundColor: theme('backgroundColor.transparent'),
        color: theme('textColor.gray.400'),

        '&:hover': {
          borderColor: theme('borderColor.gray.200')
        }
      },

      '@apply dark:bg-cyan-800 dark:border-cyan-900 dark:active:border-cyan-900': {},
    },

    '.button-danger': {
      ...buttonStyles(theme),
      backgroundColor: theme('backgroundColor.red.600'),
      borderColor: theme('borderColor.red.600'),
      color: theme('textColor.white'),
      '&:hover': {
        backgroundColor: theme('backgroundColor.red.500'),
        borderColor: theme('borderColor.red.500'),
      },
      '&:active': {
        backgroundColor: theme('backgroundColor.red.700'),
        borderColor: theme('borderColor.red.700'),
      }
    },

    '.button-danger-outlined': {
      ...buttonStyles(theme),
      backgroundColor: 'transparent',
      borderColor: theme('borderColor.red.600'),
      '&:hover': {
        color: theme('colors.white'),
        backgroundColor: theme('backgroundColor.red.600'),
        borderColor: theme('borderColor.red.600'),
      },
      '&:active': {
        backgroundColor: theme('backgroundColor.red.700'),
        borderColor: theme('borderColor.red.700')
      },
    },

    '.button-zinc-outlined': {
      ...buttonStyles(theme),
      borderColor: theme('borderColor.zinc.600'),
      backgroundColor: 'transparent',
      color: theme('colors.zinc.600'),
      outline: null,
      '&:hover': {
        backgroundColor: theme('backgroundColor.gray.500'),
        color: theme('colors.white')
      },
      '&:active': {
        backgroundColor: theme('backgroundColor.gray.600'),
      },
      '&:disabled': {
        cursor: theme('cursor.not-allowed'),
        backgroundColor: theme('backgroundColor.transparent'),
        color: theme('textColor.gray.400'),
        borderColor: theme('borderColor.zinc.400')
      },

      '@apply dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800  dark:hover:text-white  dark:active:bg-zinc-900': {}
    },
  });
});