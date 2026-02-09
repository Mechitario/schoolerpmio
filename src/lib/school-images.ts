/**
 * Default school images from Unsplash (free to use).
 * Format: https://images.unsplash.com/photo-{id}?w={width}&q=80
 */
const unsplash = (id: string, w = 1200) =>
  `https://images.unsplash.com/photo-${id}?w=${w}&q=80`

export const schoolImages = {
  // Hero & branding
  hero: unsplash('1580582932707-520a2849376f', 1400),       // School building
  heroMobile: unsplash('1580582932707-520a2849376f', 800),
  logo: unsplash('1523050854058-8df90110c9f1', 200),        // Students (used as logo placeholder)

  // Sections
  classroom: unsplash('1509062522246-3755977927d7', 800),   // Classroom
  library: unsplash('1481627834876-b7833e8f5570', 800),     // Library
  students: unsplash('1523050854058-8df90110c9f1', 800),    // Students
  graduation: unsplash('1523050874232-4740a69a21c4', 800),  // Graduation
  campus: unsplash('1562774053-701939374585', 800),         // Campus exterior
  learning: unsplash('1503676260728-1c00da094a0b', 800),    // Kids learning
  teacher: unsplash('1522202176988-66273c2fd55f', 400),    // People/team
  science: unsplash('1507413245164-6160d8298b31', 800),    // Science

  // Cards & thumbnails (smaller)
  cardClassroom: unsplash('1509062522246-3755977927d7', 400),
  cardLibrary: unsplash('1481627834876-b7833e8f5570', 400),
  cardCampus: unsplash('1562774053-701939374585', 400),
} as const
