'use client'

import React, { useState } from 'react'
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from 'recharts'
import { Wallet, Search, CheckCircle2, AlertCircle, Clock, Plus, Download, ChevronDown } from 'lucide-react'
import {
  DataTable,
  DataTableHeader,
  DataTableHeaderCell,
  DataTableBody,
  DataTableRow,
  DataTableCell,
  DataTableFooter,
} from '../../components/DataTable'

const COLLECTION_BY_MONTH = [
  { month: 'Jul', collected: 38500, target: 42000 },
  { month: 'Aug', collected: 41200, target: 42000 },
  { month: 'Sep', collected: 39800, target: 42000 },
  { month: 'Oct', collected: 43500, target: 42000 },
  { month: 'Nov', collected: 42800, target: 42000 },
  { month: 'Dec', collected: 45200, target: 42000 },
]

const feeRecords = [
  { id: '1', name: 'Arjun Verma', roll: '101', class: '10th', section: 'A', month: 'February', amount: 450, status: 'Paid' as const, date: 'Feb 05, 2026' },
  { id: '2', name: 'Priya Singh', roll: '102', class: '10th', section: 'B', month: 'February', amount: 450, status: 'Pending' as const, date: '—' },
  { id: '3', name: 'Rahul Dev', roll: '201', class: '12th', section: 'A', month: 'February', amount: 600, status: 'Partial' as const, date: 'Feb 01, 2026' },
  { id: '4', name: 'Simran Kaur', roll: '205', class: '12th', section: 'C', month: 'February', amount: 600, status: 'Paid' as const, date: 'Feb 03, 2026' },
  { id: '5', name: 'Aman Gupta', roll: '105', class: '10th', section: 'A', month: 'February', amount: 450, status: 'Paid' as const, date: 'Feb 04, 2026' },
  { id: '6', name: 'Lisa Ray', roll: '110', class: '11th', section: 'A', month: 'February', amount: 550, status: 'Pending' as const, date: '—' },
]

export default function FeesPage() {
  const [searchTerm, setSearchTerm] = useState('')

  const filteredFees = feeRecords.filter(
    (f) =>
      f.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      f.roll.includes(searchTerm)
  )

  const getStatusClass = (status: string) => {
    if (status === 'Paid') return 'bg-emerald-100 text-emerald-700'
    if (status === 'Pending') return 'bg-rose-100 text-rose-700'
    return 'bg-amber-100 text-amber-700'
  }

  return (
    <div className="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
      <header className="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h1 className="text-4xl font-black tracking-tight text-slate-900">Fee Management</h1>
          <p className="text-slate-500 mt-2 font-medium">Track and record student fee payments.</p>
        </div>
        <div className="flex items-center gap-3">
          <button className="flex items-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
            <Download size={18} className="text-slate-400" />
            Export
          </button>
          <button className="flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-xl shadow-primary-200 hover:bg-primary-700 transition-all active:scale-95">
            <Plus size={18} />
            Record Payment
          </button>
        </div>
      </header>

      {/* Stats */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
            <CheckCircle2 size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Paid this month</p>
            <p className="text-2xl font-black text-slate-900 mt-1">$24,500</p>
          </div>
        </div>
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600">
            <AlertCircle size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Pending</p>
            <p className="text-2xl font-black text-slate-900 mt-1">$12,400</p>
          </div>
        </div>
        <div className="bg-white p-7 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 flex items-center gap-5">
          <div className="w-14 h-14 rounded-2xl bg-primary-100 flex items-center justify-center text-primary-600">
            <Clock size={24} />
          </div>
          <div>
            <p className="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Collection rate</p>
            <p className="text-2xl font-black text-slate-900 mt-1">66%</p>
          </div>
        </div>
      </div>

      {/* Collection chart */}
      <div className="bg-white p-8 rounded-[2rem] border border-slate-200/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <div className="mb-8">
          <h2 className="text-2xl font-black text-slate-900">Monthly Collection</h2>
          <p className="text-sm font-medium text-slate-400 mt-1 uppercase tracking-wider">Collected vs target (last 6 months)</p>
        </div>
        <div className="h-[300px] w-full">
          <ResponsiveContainer width="100%" height="100%">
            <BarChart data={COLLECTION_BY_MONTH} margin={{ top: 10, right: 10, left: 0, bottom: 0 }}>
              <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" vertical={false} />
              <XAxis dataKey="month" tick={{ fontSize: 11, fill: '#64748b', fontWeight: 600 }} axisLine={{ stroke: '#e2e8f0' }} tickLine={false} />
              <YAxis tick={{ fontSize: 11, fill: '#64748b', fontWeight: 600 }} axisLine={false} tickLine={false} tickFormatter={(v) => `$${(v / 1000).toFixed(0)}k`} />
              <Tooltip
                contentStyle={{ borderRadius: 12, border: '1px solid #e2e8f0', boxShadow: '0 4px 24px rgba(0,0,0,0.08)' }}
                formatter={(value: number) => [`$${value.toLocaleString()}`, '']}
                labelFormatter={(label) => `Month: ${label}`}
              />
              <Bar dataKey="collected" name="Collected" fill="#0ea5e9" radius={[6, 6, 0, 0]} maxBarSize={48} />
              <Bar dataKey="target" name="Target" fill="#e2e8f0" radius={[6, 6, 0, 0]} maxBarSize={48} />
            </BarChart>
          </ResponsiveContainer>
        </div>
      </div>

      {/* Search */}
      <div className="bg-white p-6 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60">
        <div className="relative group">
          <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors" size={20} />
          <input
            type="text"
            placeholder="Search by student name or roll number..."
            className="w-full pl-12 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:border-primary-200 focus:ring-4 focus:ring-primary-500/5 transition-all outline-none font-medium text-sm"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
      </div>

      {/* Fee table */}
      <div className="bg-white p-8 rounded-[2rem] border border-slate-200/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <div className="flex items-center justify-between mb-8">
          <h2 className="text-2xl font-black text-slate-900">Fee Records</h2>
          <div className="flex items-center gap-2">
            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider">Month</span>
            <button className="flex items-center gap-1 px-4 py-2 bg-slate-50 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all">
              February <ChevronDown size={16} />
            </button>
          </div>
        </div>
        {filteredFees.length > 0 ? (
          <DataTable
            footer={
              <DataTableFooter>
                <p className="text-xs font-bold text-slate-400">
                  Showing {filteredFees.length} of {feeRecords.length} records
                </p>
                <div className="flex gap-2">
                  <button className="px-4 py-2 text-xs font-bold text-slate-400 bg-white border border-slate-200 rounded-xl cursor-not-allowed">Previous</button>
                  <button className="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Next</button>
                </div>
              </DataTableFooter>
            }
          >
            <DataTableHeader>
              <DataTableHeaderCell>Roll No.</DataTableHeaderCell>
              <DataTableHeaderCell>Student</DataTableHeaderCell>
              <DataTableHeaderCell>Class / Section</DataTableHeaderCell>
              <DataTableHeaderCell>Month</DataTableHeaderCell>
              <DataTableHeaderCell align="right">Amount</DataTableHeaderCell>
              <DataTableHeaderCell>Status</DataTableHeaderCell>
              <DataTableHeaderCell>Date paid</DataTableHeaderCell>
            </DataTableHeader>
            <DataTableBody>
              {filteredFees.map((record) => (
                <DataTableRow key={record.id}>
                  <DataTableCell>
                    <span className="font-bold text-slate-800">#{record.roll}</span>
                  </DataTableCell>
                  <DataTableCell>
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden border-2 border-white shadow-sm flex-shrink-0">
                        <img src={`https://ui-avatars.com/api/?name=${encodeURIComponent(record.name)}&background=random`} alt="" className="w-full h-full object-cover" />
                      </div>
                      <span className="font-bold text-slate-800">{record.name}</span>
                    </div>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="font-medium text-slate-600">{record.class}</span>
                    <span className="ml-1.5 px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded uppercase">{record.section}</span>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="font-medium text-slate-600">{record.month}</span>
                  </DataTableCell>
                  <DataTableCell align="right">
                    <span className="font-black text-slate-900">${record.amount.toLocaleString()}</span>
                  </DataTableCell>
                  <DataTableCell>
                    <span className={`inline-flex items-center gap-1.5 text-[10px] font-bold px-3 py-1.5 rounded-full ${getStatusClass(record.status)}`}>
                      <span className={`w-1.5 h-1.5 rounded-full ${record.status === 'Paid' ? 'bg-emerald-500' : record.status === 'Pending' ? 'bg-rose-500' : 'bg-amber-500'}`} />
                      {record.status}
                    </span>
                  </DataTableCell>
                  <DataTableCell>
                    <span className="text-sm font-medium text-slate-500">{record.date}</span>
                  </DataTableCell>
                </DataTableRow>
              ))}
            </DataTableBody>
          </DataTable>
        ) : (
          <div className="py-16 text-center rounded-[1.25rem] border border-slate-200/60 bg-slate-50/50">
            <Wallet className="mx-auto text-slate-300 mb-4" size={48} />
            <p className="text-lg font-bold text-slate-600">No fee records found</p>
            <p className="text-sm text-slate-400 mt-1">Try a different search term.</p>
          </div>
        )}
      </div>
    </div>
  )
}
