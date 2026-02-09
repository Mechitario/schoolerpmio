import React from 'react'
import Link from 'next/link'
import { schoolImages } from '../lib/school-images'
import { ArrowRight, BookOpen, GraduationCap, Library, MapPin, Users } from 'lucide-react'

export default function HomePage() {
  return (
    <div className="min-h-full">
      {/* Hero */}
      <section className="relative min-h-[50vh] flex items-center justify-center overflow-hidden rounded-lg border border-gray-200 mb-6">
        <div className="absolute inset-0">
          <img
            src={schoolImages.hero}
            alt="School building"
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-slate-900/60" />
        </div>
        <div className="relative z-10 text-center px-6 py-16 max-w-3xl mx-auto">
          <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight drop-shadow-lg">
            Welcome to EduManage School
          </h1>
          <p className="text-xl text-slate-200 mt-4 drop-shadow">
            Excellence in education since 1995. Building futures, one student at a time.
          </p>
          <div className="mt-8 flex flex-wrap items-center justify-center gap-4">
            <Link
              href="/dashboard"
              className="inline-flex items-center gap-2 px-4 py-2 rounded bg-blue-600 text-white text-sm font-medium hover:bg-blue-700"
            >
              Portal Login <ArrowRight size={16} />
            </Link>
            <a
              href="#about"
              className="inline-flex items-center gap-2 px-4 py-2 rounded border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50"
            >
              Learn more
            </a>
          </div>
        </div>
      </section>

      {/* About */}
      <section id="about" className="mb-16 scroll-mt-8">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
          <div className="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
            <img
              src={schoolImages.classroom}
              alt="Classroom"
              className="w-full h-80 object-cover"
            />
          </div>
          <div>
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">About Our School</h2>
            <p className="text-gray-600 leading-relaxed mb-4">
              EduManage School is a place where every child is encouraged to learn, grow, and achieve. 
              We offer a balanced curriculum from primary through senior secondary, with modern facilities 
              and dedicated teachers.
            </p>
            <p className="text-gray-600 leading-relaxed mb-6">
              Our campus includes well-equipped classrooms, a library, science and computer labs, 
              and sports facilities. We believe in holistic development and offer a range of 
              extracurricular activities.
            </p>
            <div className="flex flex-wrap gap-4 text-sm text-gray-500">
              <span className="flex items-center gap-2">
                <Users size={18} className="text-blue-600" /> 1,200+ Students
              </span>
              <span className="flex items-center gap-2">
                <GraduationCap size={18} className="text-blue-600" /> 80+ Staff
              </span>
              <span className="flex items-center gap-2">
                <MapPin size={18} className="text-blue-600" /> Est. 1995
              </span>
            </div>
          </div>
        </div>
      </section>

      {/* Features / Why Us */}
      <section className="mb-16">
        <h2 className="text-2xl font-semibold text-gray-900 mb-6 text-center">Why Choose Us</h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm">
            <img
              src={schoolImages.cardClassroom}
              alt="Quality education"
              className="w-full h-48 object-cover"
            />
            <div className="p-6">
              <div className="p-2 rounded bg-blue-50 text-blue-600 w-fit mb-3">
                <BookOpen size={20} />
              </div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">Quality Education</h3>
              <p className="text-gray-600 text-sm leading-relaxed">
                Experienced teachers and a curriculum designed to prepare students for board exams and beyond.
              </p>
            </div>
          </div>
          <div className="rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm">
            <img
              src={schoolImages.cardLibrary}
              alt="Library"
              className="w-full h-48 object-cover"
            />
            <div className="p-6">
              <div className="p-2 rounded bg-indigo-50 text-indigo-600 w-fit mb-3">
                <Library size={20} />
              </div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">Library & Resources</h3>
              <p className="text-gray-600 text-sm leading-relaxed">
                A well-stocked library and digital resources to support learning and research.
              </p>
            </div>
          </div>
          <div className="rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm">
            <img
              src={schoolImages.cardCampus}
              alt="Campus"
              className="w-full h-48 object-cover"
            />
            <div className="p-6">
              <div className="p-2 rounded bg-amber-50 text-amber-600 w-fit mb-3">
                <MapPin size={20} />
              </div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">Safe Campus</h3>
              <p className="text-gray-600 text-sm leading-relaxed">
                A secure, green campus with sports grounds and space for extracurricular activities.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="relative rounded-lg overflow-hidden bg-gray-800 text-white p-8 md:p-12 text-center border border-gray-700">
        <img
          src={schoolImages.graduation}
          alt=""
          className="absolute inset-0 w-full h-full object-cover object-center opacity-20 pointer-events-none"
          aria-hidden
        />
        <div className="relative z-10">
          <h2 className="text-xl font-semibold mb-3">Ready to get started?</h2>
          <p className="text-gray-300 text-sm mb-6 max-w-xl mx-auto">
            Parents and staff can log in to the portal to view attendance, fees, results, and more.
          </p>
          <Link
            href="/dashboard"
            className="inline-flex items-center gap-2 px-4 py-2 rounded bg-blue-600 text-white text-sm font-medium hover:bg-blue-700"
          >
            Go to Portal <ArrowRight size={16} />
          </Link>
        </div>
      </section>
    </div>
  )
}
