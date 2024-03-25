/** 
 * Define custom button's styles.
 * 
 * @param {import("tailwindcss/types/config").ThemeConfig} theme 
 */
export const buttonStyles = (theme) => ({
  borderStyle: theme('borderStyle.solid'),
  borderWidth: theme('borderWidth.DEFAULT'),
  borderRadius: theme('borderRadius.md'),
  fontWeight: theme('fontWeight.semibold'),
  fontFamily: theme('fontFamily.primary'),
  padding: theme('padding.3'),
  transitionTimingFunction: theme('transitionTimingFunction.linear'),
  transitionDuration: theme('transitionDuration.DEFAULT'),
  transitionProperty: theme('transitionProperty.colors'),
  display: 'inline-flex',
  alignItems: 'center'
})