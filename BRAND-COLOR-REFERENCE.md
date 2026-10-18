# Dabbarha Brand Color Reference

## Quick Color Guide

### Primary Colors

#### Deep Green (Primary)
- **Hex**: `#245447`
- **RGB**: rgb(36, 84, 71)
- **CSS Variable**: `var(--brand-primary)`
- **Usage**: 
  - Primary buttons and CTAs
  - Navigation highlights
  - Important links
  - Headers and hero sections
  - Selected states

#### Warm Gold (Secondary)
- **Hex**: `#E4B45D`
- **RGB**: rgb(228, 180, 93)
- **CSS Variable**: `var(--brand-secondary)`
- **Usage**:
  - Secondary buttons
  - Promotional accents
  - Badges and highlights
  - Hover states (on green backgrounds)
  - Special offers

### Neutral Colors

#### Warm Cream (Background)
- **Hex**: `#F5F0E7`
- **RGB**: rgb(245, 240, 231)
- **CSS Variable**: `var(--brand-background)`
- **Usage**:
  - Main page background
  - Section backgrounds
  - Soft container backgrounds

#### White (Surface)
- **Hex**: `#FFFFFF`
- **RGB**: rgb(255, 255, 255)
- **CSS Variable**: `var(--brand-surface)`
- **Usage**:
  - Cards
  - Forms
  - Product surfaces
  - Modals and dialogs

#### Deep Charcoal (Primary Text)
- **Hex**: `#302F2B`
- **RGB**: rgb(48, 47, 43)
- **CSS Variable**: `var(--brand-text)`
- **Usage**:
  - Headings
  - Primary text
  - Important content
  - Navigation items

#### Muted Gray (Secondary Text)
- **Hex**: `#77736B`
- **RGB**: rgb(119, 115, 107)
- **CSS Variable**: `var(--brand-text-muted)`
- **Usage**:
  - Supporting text
  - Descriptions
  - Metadata
  - Placeholder text

#### Warm Beige (Borders)
- **Hex**: `#D7CDBD`
- **RGB**: rgb(215, 205, 189)
- **CSS Variable**: `var(--brand-border)`
- **Usage**:
  - Subtle borders
  - Dividers
  - Card outlines
  - Input borders

---

## Color Combinations

### Recommended Pairings

#### High Contrast (Accessible)
- **Deep Green + White**: Primary buttons
- **Deep Charcoal + White**: Body text on cards
- **Warm Gold + Deep Charcoal**: Secondary buttons

#### Medium Contrast
- **Deep Green + Warm Cream**: Sections
- **Muted Gray + White**: Secondary text
- **Warm Beige + White**: Borders

#### Low Contrast (Subtle)
- **Deep Green (10% opacity) + Deep Green**: Light backgrounds
- **Warm Cream + White**: Soft transitions

---

## Gradient Formulas

### Primary Gradient (Deep Green)
```css
background: linear-gradient(135deg, #245447 0%, #2d6b5a 50%, #36826d 100%);
```
**Usage**: Hero sections, auth pages, page headers

### Accent Gradient (Gold Circles)
```css
background: rgba(228, 180, 93, 0.08);
```
**Usage**: Decorative elements, subtle highlights

---

## Utility Classes

### Text Colors
```css
.text-brand-primary     /* #245447 - Deep Green */
.text-brand-secondary   /* #E4B45D - Warm Gold */
.text-brand-muted       /* #77736B - Muted Gray */
```

### Background Colors
```css
.bg-brand-primary       /* #245447 - Deep Green */
.bg-brand-secondary     /* #E4B45D - Warm Gold */
.bg-brand-surface       /* #FFFFFF - White */
```

### Border Colors
```css
.border-brand           /* #D7CDBD - Warm Beige */
```

---

## Component Examples

### Primary Button
```vue
<v-btn color="primary" rounded="lg">
  Add to Cart
</v-btn>
```
**Result**: Deep green background, white text

### Secondary Button
```vue
<v-btn color="secondary" rounded="lg">
  Learn More
</v-btn>
```
**Result**: Warm gold background, charcoal text

### Outlined Button
```vue
<v-btn variant="outlined" color="primary" rounded="lg">
  View Details
</v-btn>
```
**Result**: Deep green border and text, transparent background

---

## Accessibility Notes

### WCAG Compliance
All color combinations have been selected to maintain sufficient contrast ratios:

- **Deep Green on White**: ✅ AAA (7.8:1)
- **Deep Charcoal on White**: ✅ AAA (13.2:1)
- **Warm Gold on White**: ⚠️ Use for decorative only (not body text)
- **Muted Gray on White**: ✅ AA (4.8:1)

### Best Practices
- Use Deep Green or Deep Charcoal for body text
- Use Warm Gold only for headings, accents, or large text
- Maintain minimum 3:1 contrast for interactive elements
- Test with color blindness simulators

---

## Brand Personality Through Color

### Deep Green (#245447)
- **Emotions**: Trust, stability, growth, nature
- **Conveys**: Egyptian heritage, reliability, quality
- **Psychology**: Calming, reassuring, professional

### Warm Gold (#E4B45D)
- **Emotions**: Value, warmth, optimism, energy
- **Conveys**: Affordability without cheapness, special offers
- **Psychology**: Inviting, friendly, approachable

### Warm Cream (#F5F0E7)
- **Emotions**: Comfort, cleanliness, simplicity
- **Conveys**: Household focus, practical, welcoming
- **Psychology**: Neutral, spacious, easy on the eyes

---

## Quick Migration Reference

If you need to replace old colors:

| Old Color | New Color | Context |
|-----------|-----------|---------|
| `#1a237e` | `#245447` | Primary brand |
| `#3949ab` | `#245447` | Interactive elements |
| `#283593` | `#2d6b5a` | Gradients (middle) |
| `#e8eaf6` | `rgba(36, 84, 71, 0.1)` | Light backgrounds |
| `#c5cae9` | `#D7CDBD` | Borders |

---

## Tools & Resources

### Color Contrast Checkers
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Coolors Contrast Checker](https://coolors.co/contrast-checker)

### Color Blindness Simulators
- [Coblis Color Blindness Simulator](https://www.color-blindness.com/coblis-color-blindness-simulator/)
- [Colorblind Web Page Filter](https://www.toptal.com/designers/colorfilter)

### CSS Variables in DevTools
Open browser DevTools and check `:root` for all CSS custom properties
