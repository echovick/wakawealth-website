# WAKA WEALTH WEBSITE PLAN

## Technology Stack (Current)

- **Backend**: Laravel with Inertia.js
- **Frontend**: Vue 3 + TypeScript
- **UI Components**: Reka UI (Radix-like components)
- **Styling**: Tailwind CSS v4
- **Icons**: Lucide Vue Next
- **State Management**: Vue Composition API + VueUse

---

## 1. COMPREHENSIVE SITEMAP

### Public Pages (Guest Access)

```
/ (Home)
├── /about
│   ├── /about/our-story
│   ├── /about/our-team
│   └── /about/careers
├── /properties
│   ├── /properties/sites (Land/Site & Services)
│   │   ├── /properties/sites/[location-slug]
│   │   └── /properties/sites/[property-slug]
│   └── /properties/homes (Completed Homes)
│       ├── /properties/homes/[location-slug]
│       └── /properties/homes/[property-slug]
├── /locations
│   └── /locations/[slug] (e.g., wuye, lifecamp, guzape)
├── /investment
│   ├── /investment/why-invest
│   ├── /investment/how-it-works
│   ├── /investment/diaspora
│   └── /investment/calculator (ROI Calculator)
├── /education
│   ├── /education/blog
│   │   ├── /education/blog/[category]
│   │   └── /education/blog/[slug]
│   ├── /education/guides
│   └── /education/workshops (Waka to Wealth)
├── /contact
└── /faq
```

### Authenticated Pages (Client Portal)

```
/dashboard
├── /dashboard/properties (My Properties)
├── /dashboard/investments (My Investments)
├── /dashboard/documents
├── /dashboard/payments
├── /dashboard/portfolio (Portfolio Review)
├── /dashboard/appointments
└── /dashboard/support
```

### Settings Pages (Existing - already built)

```
/settings
├── /settings/profile
├── /settings/password
├── /settings/two-factor
└── /settings/appearance
```

---

## 2. DETAILED PAGE STRUCTURES

### HOME PAGE `/`

**Layout**: Marketing Layout (Full-width, no sidebar)

**Sections**:

1. **Hero Section**
   - Full-screen slider with 3-4 slides
   - Headline: "Start the Journey. Own the Destination"
   - Subheadline: Brief tagline about wealth-building
   - CTAs: "View Properties", "Get Started"
   - Background: High-quality property/lifestyle images

2. **Trust Bar**
   - Years of experience
   - Properties sold
   - Satisfied clients
   - Locations served

3. **About Section** (Origin & Philosophy)
   - "What does Waka mean?"
   - Cultural connection
   - Brand promise
   - CTA: "Learn Our Story"

4. **Featured Locations**
   - Grid of 6-8 key locations
   - Each with image, name, property count
   - Hover effects
   - Link to location detail pages

5. **Property Categories**
   - Sites & Services
   - Homes
   - Each with featured listings (3-4 properties)

6. **Why Choose Waka Wealth**
   - 5 Unique Propositions (cards/icons)
   - Journey Partnership Model
   - Education-First Approach
   - End-to-End Security
   - Flexible Solutions
   - Diaspora Facilitation

7. **Investment Calculator Teaser**
   - Interactive ROI calculator preview
   - CTA: "Calculate Your Investment"

8. **Customer Journey Visualization**
   - 5-step journey (Awareness → Exploration → Transaction → Growth → Legacy)
   - Visual timeline/infographic

9. **Client Testimonials**
   - Carousel/grid of 3-4 testimonials
   - Photos, names, locations
   - Star ratings

10. **Education Hub Preview**
    - Latest 3 blog posts
    - Upcoming workshops
    - CTA: "Learn More"

11. **CTA Section**
    - "Ready to Start Your Journey?"
    - Email signup for newsletter
    - WhatsApp/Phone contact
    - Schedule consultation button

12. **Footer**
    - Company info
    - Quick links
    - Social media
    - Contact details

---

### ABOUT PAGE `/about`

**Layout**: Marketing Layout

**Sections**:

1. **Hero**
   - "Who We Are"
   - Brief introduction

2. **Origin & Philosophy**
   - Full brand story from docs
   - Cultural connection
   - Visual imagery

3. **Mission & Vision**
   - Side-by-side cards
   - Icons/illustrations

4. **Core Values** (6 values)
   - Accordion or card grid
   - Each with: Title, Description, Pledge
   - Icons for each value

5. **Our Team** (if applicable)
   - Photos and bios
   - Leadership team

6. **Certifications & Partnerships**
   - Trust badges
   - Partner logos

7. **CTA**
   - "Start Your Journey With Us"

---

### PROPERTIES PAGES

#### Properties Hub `/properties`

**Layout**: Marketing Layout

**Sections**:

1. **Hero** with toggle: Sites | Homes
2. **Filter Bar**
   - Location
   - Price range
   - Size
   - Status (Available, Sold, Reserved)
3. **Property Grid**
   - 12-16 properties per page
   - Card design:
     - Image
     - Title
     - Location
     - Price
     - Size
     - Status badge
     - "View Details" button
4. **Pagination**

#### Property Detail Page `/properties/{type}/{slug}`

**Layout**: Marketing Layout

**Sections**:

1. **Image Gallery**
   - Main image with thumbnail carousel
   - Lightbox/zoom functionality

2. **Property Info**
   - Title
   - Location (with map pin)
   - Price
   - Size
   - Status
   - Property ID

3. **Description**
   - Full property description
   - Features list

4. **Key Features** (icons + text)
   - Title status
   - Infrastructure
   - Amenities
   - Payment options

5. **Location Map**
   - Google Maps embed
   - Nearby amenities

6. **Payment Options**
   - Outright purchase
   - Installment plans
   - Co-investment options

7. **ROI Calculator** (for investment properties)

8. **Virtual Tour** (if available)

9. **Contact Form**
   - "Inquire About This Property"
   - WhatsApp quick link

10. **Similar Properties**
    - 3-4 related properties

---

### LOCATIONS PAGE `/locations`

**Layout**: Marketing Layout

**Sections**:

1. **Hero**
   - "Explore Our Locations"
   - Map of Abuja with pins

2. **Location Grid**
   - Card for each location:
     - Image
     - Name
     - Property count
     - Brief description
     - "View Properties" button

3. **Location Detail Page** `/locations/{slug}`
   - Hero image
   - Overview
   - Available properties
   - Infrastructure & amenities
   - Location benefits
   - Map
   - CTA

---

### INVESTMENT PAGES

#### Why Invest `/investment/why-invest`

- Benefits of real estate investment
- Market insights
- Success stories
- Data/statistics

#### How It Works `/investment/how-it-works`

- Step-by-step process
- Customer journey
- Timeline expectations
- Documentation required

#### Diaspora Investment `/investment/diaspora`

- Special section for diaspora investors
- Virtual tours
- Remote documentation
- Local representatives
- Success stories from diaspora clients
- Payment in multiple currencies
- Progress updates system

#### ROI Calculator `/investment/calculator`

- Interactive calculator
- Input: Property price, down payment, timeframe
- Output: Projected returns, payment schedule
- Comparison tool
- CTA: "Get Personalized Advice"

---

### EDUCATION HUB

#### Blog `/education/blog`

**Layout**: Marketing Layout

**Sections**:

1. **Featured Post** (Hero-style)
2. **Category Filter**
   - Investment Tips
   - Market Insights
   - Property Guides
   - Success Stories
   - Legal & Documentation
3. **Blog Grid**
   - Card design with image, title, excerpt, date, category
   - Pagination
4. **Blog Detail Page** `/education/blog/{slug}`
   - Full article
   - Author info
   - Share buttons
   - Related posts
   - Comments (optional)

#### Guides `/education/guides`

- Downloadable PDF guides
- Categories: First-time buyers, Investment strategies, Legal guides
- Lead capture (email to download)

#### Workshops `/education/workshops`

- "Waka to Wealth" monthly workshops
- Upcoming events calendar
- Registration form
- Past workshop recordings (if available)

---

### CONTACT PAGE `/contact`

**Layout**: Marketing Layout

**Sections**:

1. **Contact Form**
   - Name, Email, Phone, Subject, Message
2. **Contact Info**
   - Office address
   - Phone numbers
   - Email
   - Business hours
3. **WhatsApp Quick Contact**
4. **Map** (Office location)
5. **Social Media Links**

---

### CLIENT DASHBOARD `/dashboard`

**Layout**: App Layout (with sidebar)

#### Dashboard Overview

- Welcome message
- Quick stats: Properties owned, Total investment, Portfolio value
- Recent transactions
- Upcoming appointments
- Action items
- Quick links

#### My Properties `/dashboard/properties`

- List of owned properties
- Property cards with details
- Documents link
- Payment history

#### My Investments `/dashboard/investments`

- Investment summary
- Performance metrics
- Portfolio breakdown
- ROI tracking

#### Documents `/dashboard/documents`

- Uploaded documents organized by property
- Document types: Title, Receipts, Agreements, etc.
- Download functionality

#### Payments `/dashboard/payments`

- Payment history
- Outstanding balances
- Payment plans
- Make payment button

#### Portfolio Review `/dashboard/portfolio`

- Annual portfolio review dashboard
- Property appreciation
- Market updates
- Recommendations

#### Appointments `/dashboard/appointments`

- Schedule consultation
- Upcoming appointments
- Past appointments

#### Support `/dashboard/support`

- Contact support
- FAQs
- Live chat (if available)
- Ticket system

---

## 3. COMPONENT ARCHITECTURE

### Layouts

```
/resources/js/layouts/
├── MarketingLayout.vue (Public pages)
├── AppLayout.vue (Dashboard - existing)
├── AuthLayout.vue (Login/Register - existing)
└── SettingsLayout.vue (Settings - existing)
```

### Shared Components

```
/resources/js/components/
├── /marketing
│   ├── Hero.vue
│   ├── HeroSlider.vue
│   ├── PropertyCard.vue
│   ├── LocationCard.vue
│   ├── TestimonialCard.vue
│   ├── FeatureCard.vue
│   ├── CTASection.vue
│   ├── MarketingNav.vue
│   ├── MarketingFooter.vue
│   ├── StatsCounter.vue
│   └── Newsletter.vue
├── /property
│   ├── PropertyGrid.vue
│   ├── PropertyFilter.vue
│   ├── PropertyGallery.vue
│   ├── PropertyInfo.vue
│   └── PropertyInquiryForm.vue
├── /investment
│   ├── ROICalculator.vue
│   ├── InvestmentComparisonTable.vue
│   └── PaymentPlanTable.vue
├── /education
│   ├── BlogCard.vue
│   ├── BlogGrid.vue
│   ├── GuideCard.vue
│   └── WorkshopCard.vue
├── /contact
│   ├── ContactForm.vue
│   └── MapEmbed.vue
└── /common
    ├── Breadcrumbs.vue (existing)
    ├── Pagination.vue
    ├── SearchBar.vue
    ├── SocialShare.vue
    └── WhatsAppButton.vue
```

---

## 4. CONTENT REQUIREMENTS BY PAGE

### Content Needs Summary

| Page | Text Content | Images | Data/API |
|------|-------------|---------|----------|
| Home | Hero copy (4 slides), About section, Values summary, Testimonials (3-4) | Hero images (4), Location images (8), Team photos, Property featured images | Properties API, Testimonials API, Blog posts API |
| About | Full brand story, Mission, Vision, Values (6), Team bios | Team photos, Office photos, Brand imagery | Team data |
| Properties | Property descriptions, Features, Specs | Property photos (5-10 per property), Location images | Properties API with filters |
| Locations | Location overviews, Infrastructure details, Benefits | Location photos, Maps, Amenities icons | Locations API, Properties by location |
| Investment | Investment guides, Process steps, Calculator logic | Infographics, Charts, Success story images | Calculator data, Market data |
| Education | Blog posts (20+), Guides, Workshop details | Blog featured images, Guide covers, Workshop photos | Blog API, Workshop schedule |
| Contact | Contact info, Office hours, Map coordinates | Office photos | Contact form API |
| Dashboard | User-specific data, Notifications, Action items | Property images (user's properties) | User properties API, Payments API, Documents API |

---

## 5. NEXT STEPS & IMPLEMENTATION PRIORITY

### Phase 1: Foundation (Week 1-2)

1. Create MarketingLayout.vue
2. Build marketing navigation & footer
3. Design system implementation (colors from brand doc: black, white, red/orange, yellow, pink)
4. Create reusable UI components

### Phase 2: Core Public Pages (Week 3-4)

1. Home page
2. About page
3. Properties listing & detail
4. Locations pages

### Phase 3: Investment & Education (Week 5-6)

1. Investment section pages
2. ROI Calculator
3. Blog system
4. Contact page

### Phase 4: Client Portal (Week 7-8)

1. Dashboard overview
2. My Properties
3. Documents & Payments
4. Portfolio review

### Phase 5: Polish & Launch (Week 9-10)

1. SEO optimization
2. Performance optimization
3. Mobile responsiveness
4. Testing & QA
5. Content population

---

## 6. TECHNICAL RECOMMENDATIONS

### Routes Structure (`routes/web.php`)

```php
// Public Marketing Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Properties
Route::prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/{type}/{slug}', [PropertyController::class, 'show'])->name('properties.show');
});

// Locations
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('/locations/{slug}', [LocationController::class, 'show'])->name('locations.show');

// Investment
Route::prefix('investment')->group(function () {
    Route::get('/why-invest', [InvestmentController::class, 'whyInvest'])->name('investment.why');
    Route::get('/how-it-works', [InvestmentController::class, 'howItWorks'])->name('investment.how');
    Route::get('/diaspora', [InvestmentController::class, 'diaspora'])->name('investment.diaspora');
    Route::get('/calculator', [InvestmentController::class, 'calculator'])->name('investment.calculator');
});

// Education
Route::prefix('education')->group(function () {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
    Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Client Portal (Protected Routes)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/properties', [DashboardController::class, 'properties'])->name('dashboard.properties');
        Route::get('/investments', [DashboardController::class, 'investments'])->name('dashboard.investments');
        Route::get('/documents', [DashboardController::class, 'documents'])->name('dashboard.documents');
        Route::get('/payments', [DashboardController::class, 'payments'])->name('dashboard.payments');
        Route::get('/portfolio', [DashboardController::class, 'portfolio'])->name('dashboard.portfolio');
        Route::get('/appointments', [DashboardController::class, 'appointments'])->name('dashboard.appointments');
        Route::get('/support', [DashboardController::class, 'support'])->name('dashboard.support');
    });
});
```

---

## 7. DATABASE SCHEMA RECOMMENDATIONS

### Properties Table

```sql
properties
- id
- title
- slug
- type (enum: 'site', 'home')
- location_id (foreign key)
- description
- price
- size
- status (enum: 'available', 'reserved', 'sold')
- features (json)
- images (json)
- virtual_tour_url
- created_at
- updated_at
```

### Locations Table

```sql
locations
- id
- name
- slug
- description
- map_coordinates
- featured_image
- infrastructure (json)
- amenities (json)
- created_at
- updated_at
```

### Blog Posts Table

```sql
blog_posts
- id
- title
- slug
- excerpt
- content
- featured_image
- category
- author_id
- published_at
- created_at
- updated_at
```

### Testimonials Table

```sql
testimonials
- id
- client_name
- client_location
- content
- rating
- photo
- featured
- created_at
- updated_at
```

### User Properties Table

```sql
user_properties
- id
- user_id (foreign key)
- property_id (foreign key)
- purchase_date
- purchase_price
- payment_plan (json)
- documents (json)
- created_at
- updated_at
```

---

## 8. DESIGN SYSTEM

### Brand Colors (from brand docs)

```css
/* Primary Colors */
--color-black: #000000;
--color-white: #FFFFFF;
--color-red: #FF0000; /* Primary accent */
--color-orange: #FF8C00;
--color-yellow: #FFD700;
--color-pink: #FFC0CB;

/* Neutral Colors */
--color-gray-50: #F9FAFB;
--color-gray-100: #F3F4F6;
--color-gray-900: #111827;
```

### Typography

```css
/* Headings */
font-family: 'Inter', sans-serif;

/* Body */
font-family: 'Inter', sans-serif;
```

### Spacing & Grid

- Use Tailwind's default spacing scale
- Container max-width: 1280px
- Grid columns: 12-column grid
- Gap: 24px (desktop), 16px (mobile)

---

## 9. SEO CONSIDERATIONS

### Meta Tags (Per Page)

- Title (unique per page)
- Description
- Keywords
- OG Image
- Twitter Card

### URL Structure

- Clean, descriptive URLs
- Use slugs for dynamic pages
- Include keywords where appropriate

### Sitemap.xml

- Auto-generated via Laravel package
- Include all public pages
- Update frequency: weekly

### Schema Markup

- Organization schema
- LocalBusiness schema
- RealEstateAgent schema
- Product schema (for properties)

---

## 10. PERFORMANCE OPTIMIZATION

### Images

- Use WebP format with fallbacks
- Lazy loading for below-the-fold images
- Responsive images with srcset
- Image optimization via Laravel Intervention

### Code Splitting

- Route-based code splitting (Vite default)
- Lazy load non-critical components
- Async load third-party scripts

### Caching

- Browser caching for static assets
- Redis for database queries
- CDN for images and assets

---

## Summary

This comprehensive plan provides:

- ✅ Complete sitemap with all pages
- ✅ Detailed page structures with sections
- ✅ Component architecture
- ✅ Content requirements by page
- ✅ Implementation phases with timeline
- ✅ Route structure recommendations
- ✅ Database schema
- ✅ Design system guidelines
- ✅ SEO & performance considerations

**Next Steps**: Begin with Phase 1 (Foundation) by creating the MarketingLayout and core components, then progressively build out the public pages and client portal.
